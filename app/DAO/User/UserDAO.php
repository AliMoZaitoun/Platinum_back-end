<?php

namespace App\DAO\User;

use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateUserDTO;
use App\Exceptions\NotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserDAO
{
    public function store(CreateUserDTO $userDTO)
    {
        return User::create($userDTO->toArray());
    }

    public function findById($id)
    {
        return User::find($id) ?? throw new NotFoundException("User");
    }

    public function update($user, UpdateUserDTO $userDTO)
    {
        return $user->update($userDTO->toArray());
    }

    public function verify($user)
    {
        return $user->update(['email_verified_at' => now()]);
    }

    public function updatePassword($user, $newPassword)
    {
        return $user->update(['password' => Hash::make($newPassword)]);
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first() ?? throw new NotFoundException("User");
    }

    public function delete($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    }
}
