<?php

namespace App\DTOs\User;

class CreateEmployeeDTO
{
    public function __construct(
        public ?int $id,
        public ?int $user_id,
        public ?int $department_id,
        public ?string $position
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            id: null,
            user_id: null,
            position: $request['position'] ?? null,
            department_id: $request['department_id'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'user_id'  => $this->user_id
        ], fn($value) => !is_null($value));
    }
}
