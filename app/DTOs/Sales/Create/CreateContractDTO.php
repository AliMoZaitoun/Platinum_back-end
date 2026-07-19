<?php

namespace App\DTOs\Sales\Create;

class CreateContractDTO
{
    public function __construct(
        public int $order_id,
        public int $client_id,
        public ?int $employee_id,
        public float $total_price,
        public float $down_payment_amount,
        public int $installments_count,
        public string $status
    ) {}

    public static function fromRequest(array $request, int $employeeId)
    {
        return new self(
            employee_id: $employeeId,
            client_id: $request['client_id'],
            order_id: $request['order_id'],
            total_price: $request['total_price'],
            down_payment_amount: $request['down_payment_amount'],
            installments_count: $request['installments_count'],
            status: $request['status'] ?? 'draft'
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'order_id'              => $this->order_id,
            'client_id'             => $this->client_id,
            'employee_id'           => $this->employee_id,
            'total_price'           => $this->total_price,
            'down_payment_amount'   => $this->down_payment_amount,
            'installments_count'    => $this->installments_count,
            'status'                => $this->status
        ], fn($value) => !is_null($value));
    }
}
