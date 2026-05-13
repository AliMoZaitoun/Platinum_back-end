<?php

namespace App\Policies\V1\RealEstate;

use App\Models\RealEstate\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('read.project');
    }

    public function view(User $user, Project $project): bool
    {
        return $user->can('read.project');
    }

    public function create(User $user): bool
    {
        return $user->can('create.project');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->can('update.project');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->can('delete.project');
    }
}
