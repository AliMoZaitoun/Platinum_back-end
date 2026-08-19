<?php

namespace App\Services\Finance;

use App\DAO\Finance\PaymentDAO;
use App\DTOs\Finance\Create\CreatePaymentDTO;
use App\DTOs\Finance\Create\CreateTransactionDTO;
use App\DTOs\Finance\Update\UpdatePaymentDTO;
use App\DTOs\Sales\Create\CreateUnitOwnershipDTO;
use App\Enums\TransactionCategory;
use App\Exceptions\V1\Finance\PaymentExceedsRemainingBalanceException;
use App\Exceptions\V1\Sales\PaymentImmutableException;
use App\Models\Finance\Payment;
use App\Services\FileManagerService;
use App\Services\Sales\UnitOwnershipService;
use App\Services\Transaction;

class PaymentService
{
    public function __construct(
        private PaymentDAO $dao,
        private Transaction $transaction,
        private FileManagerService $fileManager,
        private UnitOwnershipService $ownershipService,
        private TransactionService $financeTransactionService
    ) {}

    public function index(array $filters = [], array $relations = [], int $perPage = 15)
    {
        return $this->dao->index($filters, $relations, $perPage);
    }

    public function store(CreatePaymentDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $payment = $this->dao->store($dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $payment,
                    files: $attachments,
                    folderPath: "payments",
                    relationName: 'attachments'
                );
            }

            if ($payment->status === 'paid') {
                $this->createReceiptForPayment($payment);
                $this->activateContractIfDownPaymentPaid($payment);
                $this->completeContractIfAllPaid($payment);
            }

            return $payment;
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function byClient(int $client_id)
    {
        return $this->dao->byClient($client_id);
    }

    public function byContract(int $contractId)
    {
        return $this->dao->byContract($contractId);
    }

    public function update(int $id, UpdatePaymentDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($id, $dto, $attachments) {
            $pay = $this->dao->show($id);

            if ($pay->status !== 'pending') {
                throw new PaymentImmutableException();
            }

            $payment = $this->dao->update($id, $dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $payment,
                    files: $attachments,
                    folderPath: "payments",
                    relationName: 'attachments'
                );
            }

            if ($payment->status === 'paid') {
                $this->createReceiptForPayment($payment);
                $this->activateContractIfDownPaymentPaid($payment);
                $this->completeContractIfAllPaid($payment);
            }

            return $payment;
        });
    }

    public function payCustomAmount(int $contractId, array $data, $attachments)
    {
        return $this->transaction->execute(function () use ($contractId, $data, $attachments) {

            $pendingPayments = $this->dao->getPendingByContract($contractId);

            $totalPendingAmount = $pendingPayments->sum('amount');

            if ($data['amount'] > $totalPendingAmount) {
                throw new PaymentExceedsRemainingBalanceException($data['amount'], $totalPendingAmount);
            }

            $remainingAmountToDistribute = $data['amount'];

            foreach ($pendingPayments as $payment) {
                if ($remainingAmountToDistribute <= 0) break;

                if ($remainingAmountToDistribute >= $payment->amount) {

                    $updateDto = new UpdatePaymentDTO(
                        amount: $payment->amount,
                        payment_date: $payment->payment_date,
                        payment_type: $payment->payment_type,
                        payment_method: $data['payment_method'],
                        status: 'paid'
                    );

                    $updatedPayment = $this->dao->update($payment->id, $updateDto);

                    $remainingAmountToDistribute -= $payment->amount;

                    $this->fileManager->storeFile(
                        model: $updatedPayment,
                        files: $attachments,
                        folderPath: "payments",
                        relationName: 'attachments'
                    );

                    $this->createReceiptForPayment($updatedPayment);
                    $this->activateContractIfDownPaymentPaid($updatedPayment);
                } else {


                    $unpaidBalance = $payment->amount - $remainingAmountToDistribute;

                    $updateDto = new UpdatePaymentDTO(
                        amount: $remainingAmountToDistribute,
                        payment_date: $payment->payment_date,
                        payment_type: $payment->payment_type,
                        payment_method: 'cash',
                        status: 'paid'
                    );
                    $updatedPayment = $this->dao->update($payment->id, $updateDto);

                    $this->fileManager->storeFile(
                        model: $updatedPayment,
                        files: $attachments,
                        folderPath: "payments",
                        relationName: 'attachments'
                    );

                    $this->createReceiptForPayment($updatedPayment);
                    $this->activateContractIfDownPaymentPaid($updatedPayment);

                    $splitPaymentDto = new CreatePaymentDTO(
                        contract_id: $payment->contract_id,
                        client_id: $payment->client_id,
                        employee_id: $payment->employee_id,
                        amount: $unpaidBalance,
                        payment_date: $payment->payment_date,
                        payment_type: $payment->payment_type,
                        payment_method: $payment->payment_method,
                        status: 'pending'
                    );
                    $this->dao->store($splitPaymentDto);

                    $remainingAmountToDistribute = 0;
                }
            }

            if (isset($updatedPayment)) {
                $this->completeContractIfAllPaid($updatedPayment);
            }

            return true;
        });
    }

    public function uploadFile(int $id, $attachments = null)
    {
        return $this->transaction->execute(function () use ($id, $attachments) {
            $payment = $this->dao->show($id);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $payment,
                    files: $attachments,
                    folderPath: "payments",
                    relationName: 'attachments'
                );
            }
            return $payment->refresh();
        });
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }

    private function activateContractIfDownPaymentPaid(Payment $payment): void
    {
        if ($payment->status === 'paid') {

            $contract = $payment->contract;

            if ($contract) {
                if (!in_array($contract->status, ['active', 'completed'])) {
                    $contract->update([
                        'status' => 'active'
                    ]);
                }

                $existingOwnerships = $this->ownershipService->byContract($contract->id);

                if (empty($existingOwnerships)) {
                    $data = [
                        "client_id" => $payment->client_id,
                        "contract_id" => $payment->contract_id,
                        "purchase_price" => $contract->total_price,
                    ];

                    $unitId = $contract->order?->unit_id ?? $contract->unit_id;

                    $dtoOwnerShip = CreateUnitOwnershipDTO::fromRequest($unitId, $data);
                    $this->ownershipService->store($dtoOwnerShip);
                }
            }
        }
    }

    private function completeContractIfAllPaid(Payment $payment): void
    {
        $contract = $payment->contract;

        if ($contract && $contract->status !== 'completed') {

            $totalPaid = $contract->payments()
                ->where('status', 'paid')
                ->sum('amount');

            if ($totalPaid >= $contract->total_price) {
                $contract->update([
                    'status' => 'completed'
                ]);

                $this->ownershipService->finalizeOwnershipForContract($contract->id);
            }
        }
    }

    private function createReceiptForPayment(Payment $payment): void
    {
        if ($payment->transactions()->exists()) {
            return;
        }

        $categoryEnum = TransactionCategory::tryFrom($payment->payment_type)
            ?? TransactionCategory::OTHER;

        $dto = new CreateTransactionDTO(
            type: 'receipt',
            amount: (float) $payment->amount,
            currency: $payment->contract->currency,
            exchange_rate: 1.0000,
            category: $categoryEnum,
            payment_method: $payment->payment_method,
            created_by: auth()->id() ?? $payment->employee_id,
            transactionable_type: 'payment',
            transactionable_id: $payment->id,
            party_type: 'client',
            party_id: $payment->client_id,
            status: 'posted',
            description: 'تسديد تلقائي للدفعة رقم ' . $payment->id . ' للعقد التابع للعميل'
        );

        $this->financeTransactionService->store($dto);
    }
}
