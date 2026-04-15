<?php

namespace App\DAO;

use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateUserDTO;
use App\Exceptions\NotFoundException;
use App\Models\User;

class UserDAO
{
    public function store(CreateUserDTO $userDTO)
    {
        return User::create([
            'first_name' => $userDTO->firstName,
            'last_name' => $userDTO->lastName,
            'phone' => $userDTO->phone,
            'email' => $userDTO->email,
            'gender' => $userDTO->gender,
            'address' => $userDTO->address,
            'role' => $userDTO->role,
            'password' => bcrypt($userDTO->password)
        ]);
    }

    public function findById($id)
    {
        return User::find($id) ?? throw new NotFoundException("User");
    }

    public function update($user, UpdateUserDTO $userDTO)
    {
        $user->update([
            'first_name' => $userDTO->firstName ?? $user->first_name,
            'last_name' => $userDTO->lastName ?? $user->last_name,
            'email' => $userDTO->email ?? $user->email,
            'phone' => $userDTO->phone ?? $user->phone,
            'address' => $userDTO->address ?? $user->address,
        ]);
        return $user;
    }

    public function verify($user)
    {
        return $user->update(['email_verified_at' => now()]);
    }

    public function updatePassword($user, $newPassword)
    {
        $user->password = bcrypt($newPassword);
        return $user->save();
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first() ?? throw new NotFoundException("User");
    }

    public function delete($id)
    {
        // Logic to delete a user from the database
    }
}
