<?php

namespace App\Http\Controllers;

use App\DTOs\Core\AssignEmployeeDepartmentDTO;
use App\DTOs\Core\Update\UpdateEmployeeDepartmentDTO;
use App\Http\Requests\V1\Core\AssignEmployeeDepartmentRequest;
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
        return $this->employeeDepartmentService->index();
    }

    public function store(AssignEmployeeDepartmentRequest $request)
    {
        $dto = AssignEmployeeDepartmentDTO::fromRequest($request->validated());

        $emp_dep = $this->employeeDepartmentService->store($dto);
        return $this->successResponse($emp_dep, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $emp_dep = $this->employeeDepartmentService->show($id);
        return $this->successResponse($emp_dep);
    }

    public function findByEmployee(int $employeeId)
    {
        $departments = $this->employeeDepartmentService->findByEmployee($employeeId);
        return $this->successResponse($departments);
    }

    public function findByDepartment(int $departmentId)
    {
        $employees = $this->employeeDepartmentService->findByDepartment($departmentId);
        return $this->successResponse($employees);
    }

    public function update(int $id, Request $request)
    {
        $dto = UpdateEmployeeDepartmentDTO::fromRequest($request->all());
        $emp_data = $this->employeeDepartmentService->update($id, $dto);
        return $this->successResponse($emp_data, __('messages.common.updated'));
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
