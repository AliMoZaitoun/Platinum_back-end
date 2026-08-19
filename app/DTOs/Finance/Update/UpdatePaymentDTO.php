<?php

namespace App\DTOs\Finance\Update;

class UpdatePaymentDTO
{
    public function __construct(
        private ?float $amount,
        private ?string $payment_date,
        private ?string $payment_type,
        private ?string $payment_method,
        private ?string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            amount: $request['amount'] ?? null,
            payment_date: $request['payment_date'] ?? null,
            payment_type: $request['payment_type'] ?? null,
            payment_method: $request['payment_method'] ?? null,
            status: $request['status'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'amount'            => $this->amount,
            'payment_date'      => $this->payment_date,
            'payment_type'      => $this->payment_type,
            'payment_method'    => $this->payment_method,
            'status'            => $this->status,
        ], fn($value) => !is_null($value));
    }
}
