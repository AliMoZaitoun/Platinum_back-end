<?php

namespace App\DTOs\User\Update;

class UpdateUserDTO
{
    public function __construct(
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $address = null,
    ) {}
}
