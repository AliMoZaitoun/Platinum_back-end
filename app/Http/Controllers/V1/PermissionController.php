<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Role\PermissionDTO;
use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private PermissionService $permissionService
    ) {}

    public function createRole(Request $request)
    {
        $roleDTO = new PermissionDTO(
            id: null,
            name: $request->input('name'),
            guard_name: $request->input('guard_name')
        );

        $role = $this->permissionService->createRole($roleDTO);
        return $this->successResponse($role, 'Role created successfully.');
    }

    public function getRoles()
    {
        $roles = $this->permissionService->getRoles();
        return $this->successResponse($roles, 'Roles retrieved successfully.');
    }

    public function getRoleById($role_id)
    {
        $role = $this->permissionService->getRoleById($role_id);
        return $this->successResponse($role, 'Role retrieved successfully.');
    }

    public function getRoleByName($role_name)
    {
        $role = $this->permissionService->getRoleByName($role_name);
        return $this->successResponse($role, 'Role retrieved successfully.');
    }

    public function deleteRole($role_id)
    {
        $this->permissionService->deleteRole($role_id);
        return $this->successResponse([], 'Role removed successfully.');
    }
}
