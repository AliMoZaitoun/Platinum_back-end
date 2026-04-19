<?php

namespace App\DAO\Core;

use App\DTOs\Core\CreateDepartmentDTO;
use App\DTOs\Core\Update\UpdateDepartmentDTO;
use App\Exceptions\NotFoundException;
use App\Models\Department;

class DepartmentDAO
{

    public function index()
    {
        return Department::all();
    }

    public function store(CreateDepartmentDTO $departmentDTO)
    {
        return Department::create($departmentDTO->toArray());
    }

    public function show(int $id)
    {
        return Department::find($id) ?? throw new NotFoundException("Department");
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
