<?php

namespace App\Services\User;

use App\DAO\Core\EmployeeDepartmentDAO;
use App\DAO\User\EmployeeDAO;
use App\DAO\User\UserDAO;
use App\DTOs\User\Update\UpdateEmployeeDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateEmployeeDTO;
use App\DTOs\User\CreateUserDTO;
use App\Exceptions\NotFoundException;
use App\Services\Transaction;

class EmployeeService
{
    public function __construct(
        private EmployeeDAO $employeeDAO,
        private UserDAO $userDAO,
        private EmployeeDepartmentDAO $employeeDepartmentDAO,
        private Transaction $transaction
    ) {}

    public function index()
    {
        $employees = $this->employeeDAO->index();
        if (sizeof($employees) <= 0)
            throw new NotFoundException("Employees");
        return $employees;
    }

    public function store(CreateUserDTO $userDTO, CreateEmployeeDTO $employeeDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $employeeDTO) {
            $user = $this->userDAO->store($userDTO);

            $this->userDAO->verify($user);

            $employeeDTO->user_id = $user->id;
            $this->employeeDAO->store($employeeDTO);
            return $user;
        });
    }

    public function show($id)
    {
        $employee = $this->employeeDAO->show($id);
        return $employee->user;
    }

    public function update(int $id, UpdateUserDTO $userDTO, UpdateEmployeeDTO $employeeDTO)
    {
        return $this->transaction->execute(function () use ($id, $userDTO, $employeeDTO) {
            $user = $this->show($id);
            $employee = $user->employee;
            $this->userDAO->update($user, $userDTO);
            $this->employeeDAO->update($employee, $employeeDTO);
            return $user;
        });
    }

    public function destroy($id)
    {
        $this->employeeDepartmentDAO->destroyByEmployee($id);
        return $this->employeeDAO->destroy($id);
    }
}
