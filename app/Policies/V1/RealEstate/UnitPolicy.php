<?php

namespace App\Policies\V1\RealEstate;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('read.unit');
    }

    public function view(User $user, Unit $unit): bool
    {
        return $user->can('read.unit');
    }

    public function create(User $user): bool
    {
        return $user->can('create.unit');
    }

    public function update(User $user, Unit $unit): bool
    {
        return $user->can('update.unit');
    }

    public function delete(User $user, Unit $unit): bool
    {
        return $user->can('delete.unit');
    }
}
