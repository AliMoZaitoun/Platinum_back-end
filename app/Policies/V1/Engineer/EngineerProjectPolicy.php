<?php

namespace App\Policies\V1\Engineer;

use App\Models\Engineer\ProjectEngineerAllocation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EngineerProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, ProjectEngineerAllocation $ProjectEngineerAllocation): bool
    {
        return $user->hasPermissionTo('read.engineer', 'web');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create.engineer', 'web');
    }

    public function update(User $user, ProjectEngineerAllocation $ProjectEngineerAllocation): bool
    {
        return false;
    }

    public function delete(User $user, ProjectEngineerAllocation $ProjectEngineerAllocation): bool
    {
        return false;
    }

    public function restore(User $user, ProjectEngineerAllocation $ProjectEngineerAllocation): bool
    {
        return false;
    }

    public function forceDelete(User $user, ProjectEngineerAllocation $ProjectEngineerAllocation): bool
    {
        return false;
    }
}
