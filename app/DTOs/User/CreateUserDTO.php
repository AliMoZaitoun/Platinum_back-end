<?php

namespace App\DTOs\User;

class CreateUserDTO
{
    public function __construct(
        public ?int $id,
        public string $firstName,
        public string $lastName,
        public string $address,
        public string $phone,
        public string $email,
        public string $gender,
        public string $role,
        public string $password
    ) {}

    public static function fromRequest(array $request, string $role): self
    {
        return new self(
            id: null,
            firstName: $request['first_name'],
            lastName: $request['last_name'],
            address: $request['address'],
            phone: $request['phone'],
            email: $request['email'],
            gender: $request['gender'],
            role: $role,
            password: $request['password']
        );
    }
}
