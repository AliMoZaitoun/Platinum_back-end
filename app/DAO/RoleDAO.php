<?php

namespace App\DAO;

use App\DTOs\Role\RoleDTO;
use App\Exceptions\NotFoundException;
use Spatie\Permission\Models\Role;

class RoleDAO
{
    public function createRole(RoleDTO $roleDTO)
    {
        return Role::create($roleDTO->toArray());
    }

    public function getRoles()
    {
        return Role::all();
    }

    public function getRoleById($role_id)
    {
        return Role::findById($role_id) ?? throw new NotFoundException('Role');
    }

    public function getRoleByName($role_name)
    {
        return Role::findByName($role_name) ?? throw new NotFoundException('Role');
    }

    public function updateRole(Role $role, RoleDTO $roleDTO)
    {
        return $role->update(array_filter($roleDTO->toArray(), fn($v) => !is_null($v)));
    }

    public function deleteRole(Role $role)
    {
        return $role->delete();
    }
}
