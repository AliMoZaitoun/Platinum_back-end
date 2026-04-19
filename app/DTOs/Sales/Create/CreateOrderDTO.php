<?php

namespace App\DTOs\Sales\Create;

class CreateOrderDTO
{
    public function __construct(
        public int $client_id,
        public int $unit_id,
        public int $offering_id,
        public string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            client_id: $request['client_id'],
            unit_id: $request['unit_id'],
            offering_id: $request['offering_id'],
            status: $request['status']
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
