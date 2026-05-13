<?php

namespace App\Policies\V1\Engineer;

use App\Models\Engineer\EngineerProject;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EngineerProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, EngineerProject $engineerProject): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return $user->can('create.engineer');
    }

    public function update(User $user, EngineerProject $engineerProject): bool
    {
        return false;
    }

    public function delete(User $user, EngineerProject $engineerProject): bool
    {
        return false;
    }

    public function restore(User $user, EngineerProject $engineerProject): bool
    {
        return false;
    }

    public function forceDelete(User $user, EngineerProject $engineerProject): bool
    {
        return false;
    }
}
