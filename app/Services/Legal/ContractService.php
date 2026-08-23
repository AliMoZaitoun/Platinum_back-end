<?php

namespace App\Services\Legal;

use App\DAO\Finance\ContractExceptionDAO;
use App\DAO\Legal\ContractDAO;
use App\DAO\Finance\PaymentDAO;
use App\DAO\Sales\AppointmentDAO;
use App\DTOs\Legal\Create\CreateContractDTO;
use App\DTOs\Finance\Create\CreatePaymentDTO;
use App\DTOs\Legal\Update\UpdateContractDTO;
use App\Exceptions\V1\Legal\ContractNotPending;
use App\Exceptions\V1\Legal\CouldnotChangeNotDraftContract;
use App\Exceptions\V1\Legal\MissingAppointmentException;
use App\Services\FileManagerService;
use App\Services\Sales\OrderService;
use App\Services\Transaction;
use Carbon\Carbon;
use Exception;

class ContractService
{
    public function __construct(
        private ContractDAO $dao,
        private ContractExceptionDAO $contractExceptionDAO,
        private Transaction $transaction,
        private PaymentDAO $paymentDAO,
        private FileManagerService $fileManager,
        private OrderService $orderService,
        private AppointmentDAO $appointmentDAO
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        return $this->dao->index($relations, $perPage);
    }

    public function store(CreateContractDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $hasDoneAppointment = $this->appointmentDAO->byOrder($dto->orderId);

            if (!$hasDoneAppointment) {
                throw new MissingAppointmentException();
            }

            $order = $this->orderService->show($dto->orderId);

            $order->update(['status' => 'accepted']);

            $clientId = $order->client_id;

            $hasException = $dto->exception !== null;
            $status = $hasException ? 'pending_approval' : 'draft';

            $contractData = array_merge($dto->toArray(), [
                'client_id' => $clientId,
                'status'    => $status
            ]);

            $contract = $this->dao->storeArray($contractData);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $contract,
                    files: $attachments,
                    folderPath: "contracts",
                    relationName: 'attachments'
                );
            }

            if ($hasException) {
                $this->contractExceptionDAO->store(
                    $dto->exception,
                    $contract->id,
                    $dto->employeeId
                );
            } else {
                $this->generatePayments($contract);
                event(new \App\Events\Contract\ContractCreated($contract));
            }

            return $contract->load(['latestException', 'payments']);
        });
    }

    public function generatePayments($contract)
    {
        $baseDate = Carbon::now();

        if ($contract->down_payment_amount > 0) {
            $downPaymentDTO = new CreatePaymentDTO(
                contract_id: $contract->id,
                client_id: $contract->client_id,
                employee_id: $contract->employee_id,
                amount: $contract->down_payment_amount,
                payment_date: $baseDate->toDateTimeString(),
                payment_type: 'down_payment',
                payment_method: 'cash',
                status: 'pending'
            );
            $this->paymentDAO->store($downPaymentDTO);
        }

        if ($contract->installments_count > 0) {
            $remainingAmount = $contract->total_price - $contract->down_payment_amount;
            $installmentAmount = $remainingAmount / $contract->installments_count;

            for ($i = 0; $i < $contract->installments_count; $i++) {
                $dueDate = $baseDate->copy()->addMonths($i + 1);

                $paymentDTO = new CreatePaymentDTO(
                    contract_id: $contract->id,
                    client_id: $contract->client_id,
                    employee_id: $contract->employee_id,
                    amount: $installmentAmount,
                    payment_date: $dueDate->toDateTimeString(),
                    payment_type: 'installment',
                    payment_method: 'cash',
                    status: 'pending'
                );
                $this->paymentDAO->store($paymentDTO);
            }
        } else {
            $finalRemaining = $contract->total_price - $contract->down_payment_amount;
            if ($finalRemaining > 0) {
                $paymentDTO = new CreatePaymentDTO(
                    contract_id: $contract->id,
                    client_id: $contract->client_id,
                    employee_id: $contract->employee_id,
                    amount: $finalRemaining,
                    payment_date: $baseDate->toDateTimeString(),
                    payment_type: 'final_payment',
                    payment_method: 'cash',
                    status: 'pending'
                );
                $this->paymentDAO->store($paymentDTO);
            }
        }
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function showByRef(string $reference_number)
    {
        return $this->dao->byRef($reference_number);
    }

    public function byClient(int $client_id)
    {
        return $this->dao->byClient($client_id);
    }

    public function getPendingApprovalContracts(array $relations = [], int $perPage = 15)
    {
        return $this->dao->getPendingApprovalContracts($relations, $perPage);
    }

    // public function approveException(int $contractId)
    // {
    //     return $this->transaction->execute(function () use ($contractId) {
    //         $contract = $this->dao->show($contractId);

    //         if ($contract->status !== 'pending_approval') {
    //             throw new ContractNotPending();
    //         }

    //         $this->dao->updateStatus($contractId, 'draft');

    //         $this->generatePayments($contract);

    //         return $contract->refresh()->load(['payments', 'latestException']);
    //     });
    // }

    // public function rejectException(int $contractId)
    // {
    //     return $this->transaction->execute(function () use ($contractId) {
    //         $contract = $this->dao->show($contractId);

    //         if ($contract->status !== 'pending_approval') {
    //             throw new ContractNotPending();
    //         }

    //         $this->dao->updateStatus($contractId, 'rejected');

    //         // $this->contractExceptionDAO->updateStatus($contract->latestException->id, 'rejected');

    //         return $contract->refresh();
    //     });
    // }

    public function changeStatus(int $id, UpdateContractDTO $dto)
    {
        $contract = $this->dao->show($id);
        if ($contract->status != 'draft') {
            throw new CouldnotChangeNotDraftContract();
        }
        return $this->dao->updateStatus($id, $dto->status);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
