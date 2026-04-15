<?php

namespace App\DTOs\User\Update;

class UpdateEmployeeDTO
{
    public function __construct(
        public ?int $user_id = null,
    ) {}
}
