<?php

namespace App\DAO;

use App\DTOs\User\Update\UpdateEmployeeDTO;
use App\DTOs\User\CreateEmployeeDTO;
use App\Models\Employee;

class EmployeeDAO
{
    public function store(CreateEmployeeDTO $employeeDTO)
    {
        return Employee::create($employeeDTO);
    }

    public function find($id)
    {
        return Employee::find($id);
    }

    public function update($employee, UpdateEmployeeDTO $employeeDTO)
    {
        // Logic to update employee data in the database
    }

    public function delete($id)
    {
        // Logic to delete an employee from the database
    }
}
