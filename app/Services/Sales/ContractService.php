<?php

namespace App\Services\Sales;

use App\DAO\Sales\ContractDAO;
use App\DAO\Sales\PaymentDAO;
use App\DTOs\Sales\Create\CreateContractDTO;
use App\DTOs\Sales\Create\CreatePaymentDTO;
use App\DTOs\Sales\Update\UpdateContractDTO;
use App\Services\FileManagerService;
use App\Services\Transaction;
use Carbon\Carbon;

class ContractService
{
    public function __construct(
        private ContractDAO $dao,
        private Transaction $transaction,
        private PaymentDAO $paymentDAO,
        private FileManagerService $fileManager,
        private OrderService $orderService
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        return $this->dao->index($relations, $perPage);
    }

    public function store(CreateContractDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $order = $this->orderService->show($dto->order_id);
            $dto->client_id = $order->client_id;

            $contract = $this->dao->store($dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $contract,
                    files: $attachments,
                    folderPath: "contracts",
                    relationName: 'attachments'
                );
            }
            $baseDate = Carbon::now();

            if ($dto->down_payment_amount > 0) {
                $downPaymentDTO = new CreatePaymentDTO(
                    contract_id: $contract->id,
                    client_id: $dto->client_id,
                    employee_id: $dto->employee_id,
                    amount: $dto->down_payment_amount,
                    payment_date: $baseDate->toDateTimeString(),
                    payment_type: 'down_payment',
                    payment_method: 'cash',
                    status: 'paid'
                );
                $this->paymentDAO->store($downPaymentDTO);
            }

            if ($dto->installments_count > 0) {
                $remainingAmount = $dto->total_price - $dto->down_payment_amount;
                $installmentAmount = $remainingAmount / $dto->installments_count;

                for ($i = 0; $i < $dto->installments_count; $i++) {
                    $dueDate = $baseDate->copy()->addMonths($i + 1);

                    $paymentDTO = new CreatePaymentDTO(
                        contract_id: $contract->id,
                        client_id: $dto->client_id,
                        employee_id: $dto->employee_id,
                        amount: $installmentAmount,
                        payment_date: $dueDate->toDateTimeString(),
                        payment_type: 'installment',
                        payment_method: 'cash',
                        status: 'pending'
                    );
                    $this->paymentDAO->store($paymentDTO);
                }
            } else {
                $finalRemaining = $dto->total_price - $dto->down_payment_amount;
                if ($finalRemaining > 0) {
                    $paymentDTO = new CreatePaymentDTO(
                        contract_id: $contract->id,
                        client_id: $dto->client_id,
                        employee_id: $dto->employee_id,
                        amount: $finalRemaining,
                        payment_date: $baseDate->toDateTimeString(),
                        payment_type: 'final_payment',
                        payment_method: 'cash',
                        status: 'pending'
                    );
                    $this->paymentDAO->store($paymentDTO);
                }
            }

            return $contract;
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

    public function changeStatus(int $id, UpdateContractDTO $dto)
    {
        return $this->dao->changeStatus($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
