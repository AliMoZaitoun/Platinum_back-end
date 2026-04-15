<?php

namespace App\Http\Controllers\V1;

use App\DTOs\User\Update\UpdateEmployeeDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateEmployeeDTO;
use App\DTOs\User\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EmployeeRequest;
use App\Services\EmployeeService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private EmployeeService $employeeService
    ) {}

    public function registerEmployee(EmployeeRequest $employeeRequest)
    {
        $userDTO = CreateUserDTO::fromRequest($employeeRequest->all(), 'employee');

        $employeeDTO = new CreateEmployeeDTO(
            id: null,
            user_id: null
        );

        $data = $this->employeeService->createEmployee($userDTO, $employeeDTO);
        return $this->successResponse($data);
    }

    public function update(Request $request)
    {
        $userDTO = new UpdateUserDTO(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            address: $request->input('address'),
            phone: $request->input('phone'),
            email: $request->input('email')
        );

        $employeeDTO = new UpdateEmployeeDTO(
            user_id: null
        );

        $employee = $this->employeeService->updateEmployee($userDTO, $employeeDTO);
        return $this->successResponse($employee, 'Employee updated successfully');
    }
}
