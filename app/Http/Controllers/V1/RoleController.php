<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Role\RoleDTO;
use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private RoleService $roleService
    ) {}

    public function createRole(Request $request)
    {
        $roleDTO = new RoleDTO(
            id: null,
            name: $request->input('name'),
            guard_name: $request->input('guard_name')
        );

        $role = $this->roleService->createRole($roleDTO);
        return $this->successResponse($role, 'Role created successfully.');
    }

    public function getRoles()
    {
        $roles = $this->roleService->getRoles();
        return $this->successResponse($roles, 'Roles retrieved successfully.');
    }

    public function getRoleById($role_id)
    {
        $role = $this->roleService->getRoleById($role_id);
        return $this->successResponse($role, 'Role retrieved successfully.');
    }

    public function getRoleByName($role_name)
    {
        $role = $this->roleService->getRoleByName($role_name);
        return $this->successResponse($role, 'Role retrieved successfully.');
    }

    public function deleteRole($role_id)
    {
        $this->roleService->deleteRole($role_id);
        return $this->successResponse([], 'Role removed successfully.');
    }
}
