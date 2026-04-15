<?php

namespace App\Services;

use App\DAO\EmployeeDAO;
use App\DAO\UserDAO;
use App\DTOs\User\Update\UpdateEmployeeDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateEmployeeDTO;
use App\DTOs\User\CreateUserDTO;
use Illuminate\Support\Facades\Auth;

class EmployeeService
{
    public function __construct(
        private EmployeeDAO $employeeDAO,
        private UserDAO $userDAO,
        private OtpService $otpService,
        private Transaction $transaction
    ) {}

    public function createEmployee(CreateUserDTO $userDTO, CreateEmployeeDTO $employeeDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $employeeDTO) {
            $user = $this->userDAO->store($userDTO);
            $employeeDTO->user_id = $user->id;
            $this->otpService->createCode($user->id);
            return $this->employeeDAO->store($employeeDTO);
        });
    }

    public function getEmployee($id)
    {
        // Logic to retrieve an employee by ID
    }

    public function updateEmployee(UpdateUserDTO $userDTO, UpdateEmployeeDTO $employeeDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $employeeDTO) {
            $user = Auth::user();
            $employee = $user->employee;
            $this->userDAO->update($user, $userDTO);
            return $this->employeeDAO->update($employee, $employeeDTO);
        });
    }
}
