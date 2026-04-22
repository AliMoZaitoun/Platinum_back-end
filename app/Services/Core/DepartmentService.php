<?php

namespace App\Services\Core;

use App\DAO\Core\DepartmentDAO;
use App\DAO\Core\EmployeeDepartmentDAO;
use App\DTOs\Core\AssignEmployeeDepartmentDTO;
use App\DTOs\Core\CreateDepartmentDTO;
use App\DTOs\Core\Update\UpdateDepartmentDTO;

class DepartmentService
{
    public function __construct(
        private DepartmentDAO $departmentDAO,
        private EmployeeDepartmentDAO $employeeDepartmentDAO
    ) {}

    public function index()
    {
        return $this->departmentDAO->index();
    }

    public function store(CreateDepartmentDTO $departmentDTO)
    {
        return $this->departmentDAO->store($departmentDTO);
    }

    public function show($id)
    {
        return $this->departmentDAO->show($id);
    }

    public function update(int $id, UpdateDepartmentDTO $departmentDTO)
    {
        return $this->departmentDAO->update($id, $departmentDTO);
    }

    public function destroy(int $id)
    {
        $this->employeeDepartmentDAO->destroyByDepartment($id);
        return $this->departmentDAO->destroy($id);
    }

    public function assign(AssignEmployeeDepartmentDTO $dto)
    {
        return $this->employeeDepartmentDAO->store($dto);
    }
}
