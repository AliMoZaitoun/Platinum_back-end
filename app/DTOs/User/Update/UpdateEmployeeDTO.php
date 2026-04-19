<?php

namespace App\DTOs\User\Update;

class UpdateEmployeeDTO
{
    public function __construct(
        public ?int $user_id = null,
        public ?string $position = null
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            position: $request['position'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'position' => $this->position,
        ], fn($value) => !is_null($value));
    }
}
