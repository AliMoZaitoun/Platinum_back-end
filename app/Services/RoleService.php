<?php

namespace App\Services;

use App\DAO\RoleDAO;
use App\DTOs\Role\CreateRoleDTO;
use App\DTOs\Role\Update\UpdateRoleDTO;

class RoleService
{
    public function __construct(
        private RoleDAO $roleDAO
    ) {}

    public function index()
    {
        return $this->roleDAO->index();
    }

    public function store(CreateRoleDTO $roleDTO)
    {
        return $this->roleDAO->store($roleDTO);
    }

    public function show($id)
    {
        return $this->roleDAO->show($id);
    }

    public function showByName($role_name)
    {
        return $this->roleDAO->showByName($role_name);
    }

    public function update(int $id, UpdateRoleDTO $roleDTO)
    {
        return $this->roleDAO->update($id, $roleDTO);
    }

    public function selectPermission(int $id, array $permissions)
    {
        return $this->roleDAO->selectPermissions($id, $permissions);
    }

    public function removePermission(int $id, array $permissions)
    {
        $role = $this->roleDAO->show($id);
        foreach ($permissions as $per) {
            $this->roleDAO->removePermission($role, $per);
        }
        return $role;
    }

    public function destroy($id)
    {
        return $this->roleDAO->destroy($id);
    }
}
