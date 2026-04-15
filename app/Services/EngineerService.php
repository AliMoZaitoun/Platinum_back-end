<?php

namespace App\Services;

use App\DAO\EngineerDAO;
use App\DAO\UserDAO;
use App\DTOs\User\Update\UpdateEngineerDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateEngineerDTO;
use App\DTOs\User\CreateUserDTO;
use Illuminate\Support\Facades\Auth;

class EngineerService
{

    public function __construct(
        private EngineerDAO $engineerDAO,
        private UserDAO $userDAO,
        private OtpService $otpService,
        private Transaction $transaction
    ) {}

    public function createEngineer(CreateUserDTO $userDTO, CreateEngineerDTO $engineerDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $engineerDTO) {
            $user = $this->userDAO->store($userDTO);
            $engineerDTO->user_id = $user->id;
            $this->otpService->createCode($user->id);
            return $this->engineerDAO->store($engineerDTO);
        });
    }

    public function getEngineer($id)
    {
        // Logic to retrieve an engineer by ID
    }

    public function updateEngineer(UpdateUserDTO $userDTO, UpdateEngineerDTO $engineerDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $engineerDTO) {
            $user = Auth::user();
            $engineer = $user->engineer;
            $this->userDAO->update($user, $userDTO);
            return $this->engineerDAO->update($engineer, $engineerDTO);
        });
    }
}
