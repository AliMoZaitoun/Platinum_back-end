<?php

namespace App\DTOs\Sales\Create;

class CreateOrderDTO
{
    public function __construct(
        public int $client_id,
        public ?int $unit_id,
        public ?int $solution_id,
        public ?int $department_id,
        public string $status
    ) {}

    public static function fromRequest(array $request, int $clientId)
    {
        return new self(
            client_id: $clientId,
            unit_id: $request['unit_id'] ?? null,
            solution_id: $request['solution_id'] ?? null,
            department_id: $request['department_id'] ?? null,
            status: $request['status'] ?? 'pending'
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'client_id'  => $this->client_id,
            'unit_id'    => $this->unit_id,
            'solution_id' => $this->solution_id,
            'department_id' => $this->department_id,
            'status'     => $this->status
        ], fn($value) => !is_null($value));
    }
}
