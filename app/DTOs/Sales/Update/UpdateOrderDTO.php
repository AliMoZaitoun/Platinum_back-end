<?php

namespace App\DTOs\Sales\Update;

class UpdateOrderDTO
{
    public function __construct(
        public ?string $status,
        public ?int $department_id,
        public ?string $notes
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            status: $request['status'] ?? null,
            department_id: $request['department_id'] ?? null,
            notes: $request['notes'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'status'     => $this->status,
            'department_id' => $this->department_id,
            'notes' => $this->notes,
        ], fn($value) => !is_null($value));
    }
}
