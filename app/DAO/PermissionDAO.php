<?php

namespace App\DAO;

use App\DTOs\Role\PermissionDTO;
use App\Exceptions\NotFoundException;
use Spatie\Permission\Models\Permission;

class PermissionDAO
{
    public function createPermission(PermissionDTO $permissionDTO)
    {
        return Permission::create($permissionDTO->toArray());
    }

    public function getPermissions()
    {
        return Permission::all();
    }

    public function getPermissionById($permission_id)
    {
        return Permission::findById($permission_id) ?? throw new NotFoundException('Permission');
    }

    public function getPermissionByName($permission_name)
    {
        return Permission::findByName($permission_name) ?? throw new NotFoundException('Permission');
    }

    public function updatePermission(Permission $permission, PermissionDTO $permissionDTO)
    {
        return $permission->update(array_filter($permissionDTO->toArray(), fn($v) => !is_null($v)));
    }

    public function deletePermission(Permission $permission)
    {
        return $permission->delete();
    }
}
