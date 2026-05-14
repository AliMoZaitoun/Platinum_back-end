<?php

namespace App\Http\Controllers\V1\Core;

use App\DTOs\Core\Create\AssignEmployeeDepartmentDTO;
use App\DTOs\Core\Update\UpdateEmployeeDepartmentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\AssignEmployeeDepartmentRequest;
use App\Http\Resources\V1\Core\EmployeeDepartmentResource;
use App\Services\Core\EmployeeDepartmentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EmployeeDepartmentController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private EmployeeDepartmentService $employeeDepartmentService
    ) {}

    public function index()
    {
        $emp_deps = $this->employeeDepartmentService->index();
        return $this->successCollection($emp_deps, EmployeeDepartmentResource::class);
    }

    public function store(AssignEmployeeDepartmentRequest $request)
    {
        $dto = AssignEmployeeDepartmentDTO::fromRequest($request->validated());

        $emp_dep = $this->employeeDepartmentService->store($dto);
        return $this->useResource($emp_dep, EmployeeDepartmentResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $emp_dep = $this->employeeDepartmentService->show($id);
        return $this->useResource($emp_dep, EmployeeDepartmentResource::class);
    }

    public function findByEmployee(int $employeeId)
    {
        $departments = $this->employeeDepartmentService->findByEmployee($employeeId);
        return $this->successCollection($departments, EmployeeDepartmentResource::class);
    }

    public function findByDepartment(int $departmentId)
    {
        $employees = $this->employeeDepartmentService->findByDepartment($departmentId);
        return $this->successCollection($employees, EmployeeDepartmentResource::class);
    }

    public function update(int $id, Request $request)
    {
        $dto = UpdateEmployeeDepartmentDTO::fromRequest($request->all());
        $emp_data = $this->employeeDepartmentService->update($id, $dto);
        return $this->useResource($emp_data, EmployeeDepartmentResource::class, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->employeeDepartmentService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }

    public function destroyByEmployee(int $employeeId)
    {
        $this->employeeDepartmentService->destroyByEmployee($employeeId);
        return $this->successResponse([], __('messages.common.deleted'));
    }

    public function destroyByDepartment(int $departmentId)
    {
        $this->employeeDepartmentService->destroyByDepartment($departmentId);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
