<?php

namespace App\DAO\User;

use App\DTOs\User\Update\UpdateEmployeeDTO;
use App\DTOs\User\CreateEmployeeDTO;
use App\Exceptions\NotFoundException;
use App\Models\Employee;

class EmployeeDAO
{

    public function index()
    {
        return Employee::all();
    }

    public function store(CreateEmployeeDTO $employeeDTO)
    {
        $employee = Employee::create($employeeDTO->toArray());
        $employee->user->assignRole('employee');
        return $employee;
    }

    public function show($id)
    {
        return Employee::find($id) ?? throw new NotFoundException("Employee");
    }

    public function update($employee, UpdateEmployeeDTO $employeeDTO)
    {
        $employee->update($employeeDTO->toArray());
    }

    public function destroy($id)
    {
        $employee = $this->show($id);
        return $employee->user->delete();
    }
}
