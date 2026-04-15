<?php

namespace App\Http\Controllers\V1;

use App\DTOs\User\Update\UpdateEngineerDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateEngineerDTO;
use App\DTOs\User\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EngineerRequest;
use App\Services\EngineerService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EngineerController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private EngineerService $engineerService
    ) {}

    public function registerEngineer(EngineerRequest $engineerRequest)
    {
        $userDTO = CreateUserDTO::fromRequest($engineerRequest->all(), 'engineer');

        $engineerDTO = new CreateEngineerDTO(
            id: null,
            user_id: null,
            experience_years: $engineerRequest->input('experience_years'),
            specialization: $engineerRequest->input('specialization')
        );

        $data = $this->engineerService->createEngineer($userDTO, $engineerDTO);
        return $this->successResponse($data);
    }

    public function updateEngineer(Request $request)
    {
        $userDTO = new UpdateUserDTO(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            address: $request->input('address'),
            phone: $request->input('phone'),
            email: $request->input('email')
        );

        $engineerDTO = new UpdateEngineerDTO(
            id: null,
            user_id: null,
            experience_years: $request->input('experience_years'),
            specialization: $request->input('specialization')
        );

        $engineer = $this->engineerService->updateEngineer($userDTO, $engineerDTO);
        return $this->successResponse($engineer, 'Engineer updated successfully');
    }
}
