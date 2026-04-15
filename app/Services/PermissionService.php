<?php

namespace App\Services;

use App\DAO\PermissionDAO;
use App\DTOs\Role\PermissionDTO;

class PermissionService
{
    public function __construct(
        private PermissionDAO $permissionDAO
    ) {}

    public function createPermission(PermissionDTO $permissionDTO)
    {
        return $this->permissionDAO->createPermission($permissionDTO);
    }

    public function getPermissions()
    {
        return $this->permissionDAO->getPermissions();
    }

    public function getPermissionById($permissionDTO)
    {
        return $this->permissionDAO->getPermissionById($permissionDTO);
    }

    public function getPermissionByName($permission_name)
    {
        return $this->permissionDAO->getPermissionByName($permission_name);
    }

    public function deletePermission($permission_id)
    {
        $permission = $this->permissionDAO->getPermissionById($permission_id);
        return $this->permissionDAO->deletePermission($permission);
    }
}
