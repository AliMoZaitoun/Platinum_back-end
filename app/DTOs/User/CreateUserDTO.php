<?php

namespace App\DTOs\User;

use Illuminate\Support\Facades\Hash;

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
        public string $password,
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
            password: $request['password'],
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'gender'     => $this->gender,
            'address'    => $this->address,
            'role'       => $this->role,
            'password'   => Hash::make($this->password),
        ];
    }
}
