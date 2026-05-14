<?php

namespace App\DAO\Core;

use App\DTOs\Core\Create\CreateDepartmentDTO;
use App\DTOs\Core\Update\UpdateDepartmentDTO;
use App\Exceptions\NotFoundException;
use App\Models\Core\Department;

class DepartmentDAO
{

    public function index()
    {
        return Department::with(['employees', 'employees.employee'])->get();
    }

    public function store(CreateDepartmentDTO $departmentDTO)
    {
        return Department::create($departmentDTO->toArray());
    }

    public function show(int $id)
    {
        return Department::where('id', $id)->with('employees')->get() ?? throw new NotFoundException("Department");
    }

    public function update(int $id, UpdateDepartmentDTO $departmentDTO)
    {
        $department = $this->show($id);
        $department->update($departmentDTO->toArray());
        return $department;
    }

    public function destroy(int $id)
    {
        $department = $this->show($id);
        return $department->delete();
    }
}
