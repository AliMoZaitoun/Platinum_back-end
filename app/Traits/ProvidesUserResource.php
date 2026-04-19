<?php

namespace App\Traits;

use App\Http\Resources\V1\EngineerDetailResource;
use App\Http\Resources\V1\EmployeeDetailResource;
use App\Http\Resources\V1\ClientDetailResource;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

trait ProvidesUserResource
{
    public function resolveUserResource(User $user)
    {
        if ($user->role === 'engineer') {
            $user->loadMissing('engineer');
        } elseif ($user->role === 'employee') {
            $user->loadMissing('employee');
        } elseif ($user->role === 'client') {
            $user->loadMissing('client');
        }
        return match ($user->role) {
            'engineer' => new EngineerDetailResource($user),
            'employee' => new EmployeeDetailResource($user),
            'client'   => new ClientDetailResource($user),
            default    => new UserResource($user),
        };
    }
}
