<?php

namespace App\DTOs\Sales\Create;

class CreateUnitOwnershipDTO
{
    public function __construct(
        public int $client_id,
        public int $unit_id,
        public float $purchase_price,
        public ?string $status,
        public string $owned_at,
    ) {}

    public static function fromRequest(int $unit_id, array $request)
    {
        return new self(
            client_id: $request['client_id'],
            unit_id: $unit_id,
            purchase_price: $request['purchase_price'],
            status: $request['status'] ?? null,
            owned_at: $request['owned_at'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'client_id'  => $this->client_id,
            'unit_id'    => $this->unit_id,
            'purchase_price' => $this->purchase_price,
            'status'     => $this->status,
            'owned_at'  => $this->owned_at,
        ], fn($value) => !is_null($value));
    }
}
