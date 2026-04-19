<?php

namespace App\DTOs\Sales\Update;

class UpdateOrderDTO
{
    public function __construct(
        public ?int $client_id,
        public ?int $unit_id,
        public ?int $offering_id,
        public ?string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            client_id: $request['client_id'] ?? null,
            unit_id: $request['unit_id'] ?? null,
            offering_id: $request['offering_id'] ?? null,
            status: $request['status'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'client_id'  => $this->client_id,
            'unit_id'    => $this->unit_id,
            'offering_id' => $this->offering_id,
            'status'     => $this->status
        ], fn($value) => !is_null($value));
    }
}
