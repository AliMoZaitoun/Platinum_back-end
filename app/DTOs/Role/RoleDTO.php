<?php

namespace App\DTOs\Role;

class RoleDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $guard_name
    ) {}

    public function toArray(): array
    {
        return [
            'name'          => $this->name,
            'guard_name'    => $this->guard_name
        ];
    }
}
