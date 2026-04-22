<?php

namespace App\Services\Core;

use App\DAO\Core\EmployeeDepartmentDAO;
use App\DTOs\Core\AssignEmployeeDepartmentDTO;
use App\DTOs\Core\Update\UpdateEmployeeDepartmentDTO;

class EmployeeDepartmentService
{
    public function __construct(
        private EmployeeDepartmentDAO $employeeDepartmentDAO
    ) {}

    public function index()
    {
        return $this->employeeDepartmentDAO->index();
    }

    public function store(AssignEmployeeDepartmentDTO $dto)
    {
        return $this->employeeDepartmentDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->employeeDepartmentDAO->show($id);
    }

    public function findByEmployee(int $employeeId)
    {
        return $this->employeeDepartmentDAO->findByEmployee($employeeId);
    }

    public function findByDepartment(int $departmentId)
    {
        return $this->employeeDepartmentDAO->findByDepartment($departmentId);
    }

    public function update(int $id, UpdateEmployeeDepartmentDTO $dto)
    {
        return $this->employeeDepartmentDAO->update($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->employeeDepartmentDAO->destroy($id);
    }

    public function destroyByEmployee(int $employeeId)
    {
        return $this->employeeDepartmentDAO->destroyByEmployee($employeeId);
    }

    public function destroyByDepartment(int $departmentId)
    {
        return $this->employeeDepartmentDAO->destroyByDepartment($departmentId);
    }
}
