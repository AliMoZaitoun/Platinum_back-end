<?php

namespace App\DTOs\User;

class CreateEmployeeDTO
{
    public function __construct(
        public ?int $id,
        public ?int $user_id
    ) {}
}
