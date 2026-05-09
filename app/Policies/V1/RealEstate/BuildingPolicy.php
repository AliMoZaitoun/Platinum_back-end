<?php

namespace App\Policies\V1\RealEstate;

use App\Models\Building;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BuildingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('read.building');
    }

    public function view(User $user, Building $building): bool
    {
        return $user->can('read.building');
    }

    public function create(User $user): bool
    {
        return $user->can('create.building');
    }

    public function update(User $user, Building $building): bool
    {
        return $user->can('update.building');
    }

    public function delete(User $user, Building $building): bool
    {
        return $user->can('delete.building');
    }
}
