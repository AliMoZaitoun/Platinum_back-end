<?php

namespace App\Services\Sales;

use App\DAO\Sales\PaymentDAO;
use App\DAO\Sales\TransactionDAO;
use App\DTOs\Sales\Create\CreateTransactionDTO;
use App\DTOs\Sales\Update\UpdatePaymentDTO;
use App\Models\Sales\Transaction;
use App\Services\Transaction as ServicesTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function __construct(
        protected TransactionDAO $dao,
        private ServicesTransaction $transaction,
        private PaymentDAO $paymentDAO
    ) {}

    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->dao->index($filters, [], $perPage);
    }

    public function store(CreateTransactionDTO $dto): Transaction
    {
        return $this->transaction->execute(function () use ($dto) {
            $data = $dto->toArray();

            if (isset($data['party_type'])) {
                $data['party_type'] = match ($data['party_type']) {
                    'client'   => \App\Models\Client\Client::class,
                    'employee' => \App\Models\Core\Employee::class,
                    default    => $data['party_type'],
                };
            }

            if (isset($data['transactionable_type'])) {
                $data['transactionable_type'] = match ($data['transactionable_type']) {
                    'payment' => \App\Models\Sales\Payment::class,
                    default   => $data['transactionable_type'],
                };
            }

            if ($dto->transactionable_type === 'payment' && $dto->transactionable_id) {
                $payment = $this->paymentDAO->show($dto->transactionable_id);

                if ($payment) {
                    $data['type']           = 'receipt';
                    $data['amount']         = $payment->amount;
                    $data['payment_method'] = $payment->payment_method;
                    $data['category'] = $payment->payment_type instanceof \App\Enums\TransactionCategory
                        ? $payment->payment_type->value
                        : $payment->payment_type;

                    $data['party_type'] = \App\Models\Client\Client::class;
                    $data['party_id']   = $payment->client_id;

                    $paymentDTO = UpdatePaymentDTO::fromRequest(['status' => 'paid']);
                    $this->paymentDAO->update($payment->id, $paymentDTO);
                }
            }

            if (empty($data['voucher_number'])) {
                $data['voucher_number'] = $this->generateVoucherNumber($data['type']);
            }

            return $this->dao->store($data);
        });
    }

    private function generateVoucherNumber(string $type): string
    {
        $prefix = ($type === 'receipt') ? 'REC' : 'PAY';
        $year   = date('Y');

        $lastTransaction = $this->dao->lastNumber($type, $year);

        if (! $lastTransaction || ! $lastTransaction->voucher_number) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) substr($lastTransaction->voucher_number, -5);
            $nextNumber = $lastNumber + 1;
        }

        return sprintf('%s-%s-%05d', $prefix, $year, $nextNumber);
    }

    public function show(int $id): Transaction
    {
        return $this->dao->show($id);
    }

    public function cancel(int $id, string $reason): Transaction
    {
        return $this->transaction->execute(function () use ($id, $reason) {
            $transaction = $this->dao->cancel($id, $reason);

            // event(new TransactionCancelledEvent($transaction));

            return $transaction;
        });
    }

    public function getPartyStatement(string $partyType, int $partyId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->dao->byParty($partyType, $partyId, $perPage);
    }

    public function getWarehouseTransactions(int $warehouseId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->dao->byWarehouse($warehouseId, $perPage);
    }

    public function getProjectTransactions(int $projectId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->dao->byProject($projectId, $perPage);
    }

    public function getFinancialSummary(array $filters = []): array
    {
        return $this->dao->getFinancialSummary($filters);
    }
}
