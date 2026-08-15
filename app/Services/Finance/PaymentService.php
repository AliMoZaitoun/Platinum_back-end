<?php

namespace App\Services\Finance;

use App\DAO\Finance\PaymentDAO;
use App\DTOs\Finance\Create\CreatePaymentDTO;
use App\DTOs\Finance\Update\UpdatePaymentDTO;
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
        private UnitOwnershipService $ownershipService
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        return $this->dao->index($relations, $perPage);
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

            $this->activateContractIfDownPaymentPaid($payment);

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

            $this->completeContractIfAllPaid($payment);
            $this->activateContractIfDownPaymentPaid($payment);

            return $payment;
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
        if ($payment->payment_type === 'down_payment' && $payment->status === 'paid') {

            $contract = $payment->contract;

            if ($contract && $contract->status !== 'active') {
                $contract->update([
                    'status' => 'active'
                ]);
            }
        }
    }

    private function completeContractIfAllPaid(Payment $payment): void
    {
        $contract = $payment->contract;

        if ($contract && $contract->status !== 'completed') {

            $hasUnpaidPayments = $contract->payments()
                ->whereIn('status', ['pending', 'failed'])
                ->exists();

            if (!$hasUnpaidPayments) {
                $contract->update([
                    'status' => 'completed'
                ]);

                $this->ownershipService->finalizeOwnershipForContract($contract->id);
            }
        }
    }
}
