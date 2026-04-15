<?php

namespace App\Services;

use App\DAO\RoleDAO;
use App\DTOs\Role\RoleDTO;

class RoleService
{
    public function __construct(
        private RoleDAO $roleDAO
    ) {}

    public function createRole(RoleDTO $roleDTO)
    {
        return $this->roleDAO->createRole($roleDTO);
    }

    public function getRoles()
    {
        return $this->roleDAO->getRoles();
    }

    public function getRoleById($role_id)
    {
        return $this->roleDAO->getRoleById($role_id);
    }

    public function getRoleByName($role_name)
    {
        return $this->roleDAO->getRoleByName($role_name);
    }

    public function deleteRole($role_id)
    {
        $role = $this->roleDAO->getRoleById($role_id);
        return $this->roleDAO->deleteRole($role);
    }
}
