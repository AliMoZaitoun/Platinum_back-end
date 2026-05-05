<?php

namespace App\DAO;

use App\DTOs\Role\CreateRoleDTO;
use App\DTOs\Role\Update\UpdateRoleDTO;
use App\Exceptions\NotFoundException;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleDAO
{
    public function index()
    {
        return Role::all();
    }

    public function store(CreateRoleDTO $roleDTO)
    {
        return Role::create($roleDTO->toArray());
    }

    public function show($id, $guardName = null)
    {
        return Role::findById($id, $guardName) ?? throw new NotFoundException('Role');
    }

    public function showByName($role_name)
    {
        return Role::findByName($role_name) ?? throw new NotFoundException('Role');
    }

    public function syncUserRoles(User $user, array $roles)
    {
        return $user->syncRoles($roles);
    }

    public function assignRoleToUser(User $user, string $role)
    {
        return $user->assignRole($role);
    }

    public function update(int $id, UpdateRoleDTO $roleDTO)
    {
        $role = $this->show($id);
        return $role->update($roleDTO->toArray());
    }

    public function selectPermissions(int $id, $permissions)
    {
        $role = $this->show($id);
        return $role->syncPermissions($permissions);
    }

    public function removePermission(Role $role, $permission)
    {
        return $role->revokePermissionTo($permission);
    }

    public function destroy(int $id)
    {
        $role = $this->show($id);
        return $role->delete();
    }
}
