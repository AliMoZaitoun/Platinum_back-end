<?php

namespace App\DTOs\User;

class CreateEmployeeDTO
{
    public function __construct(
        public ?int $id,
        public ?int $user_id,
        public string $position
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            id: null,
            user_id: null,
            position: $request['position']
        );
    }

    public function toArray()
    {
        return [
            'user_id'  => $this->user_id,
            'position' => $this->position
        ];
    }
}
