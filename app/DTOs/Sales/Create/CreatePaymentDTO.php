<?php

namespace App\DTOs\Sales\Create;

class CreatePaymentDTO
{
    public function __construct(
        public int $contract_id,
        public int $client_id,
        public int $employee_id,
        public float $amount,
        public string $payment_date,
        public ?string $payment_type,
        public ?string $payment_method,
        public ?string $status,
    ) {}

    public static function fromRequest(array $request, int $employeeId)
    {
        return new self(
            contract_id: $request['contract_id'],
            employee_id: $employeeId,
            client_id: $request['client_id'],
            amount: $request['amount'],
            payment_date: $request['payment_date'],
            payment_type: $request['payment_type'] ?? null,
            payment_method: $request['payment_method'] ?? null,
            status: $request['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'contract_id'       => $this->contract_id,
            'client_id'         => $this->client_id,
            'employee_id'       => $this->employee_id,
            'amount'            => $this->amount,
            'payment_date'      => $this->payment_date,
            'payment_type'      => $this->payment_type,
            'payment_method'    => $this->payment_method,
            'status'            => $this->status,
        ], fn($value) => !is_null($value));
    }
}
