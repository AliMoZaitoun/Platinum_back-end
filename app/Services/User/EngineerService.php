<?php

namespace App\Services\User;

use App\DAO\User\EngineerDAO;
use App\DAO\User\UserDAO;
use App\DTOs\User\Update\UpdateEngineerDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateEngineerDTO;
use App\DTOs\User\CreateUserDTO;
use App\Exceptions\NotFoundException;
use App\Services\OtpService;
use App\Services\Transaction;

class EngineerService
{

    public function __construct(
        private EngineerDAO $engineerDAO,
        private UserDAO $userDAO,
        private OtpService $otpService,
        private Transaction $transaction
    ) {}

    public function index()
    {
        $engineers = $this->engineerDAO->index();
        if (sizeof($engineers) <= 0)
            throw new NotFoundException("Engineers");
        return $engineers;
    }

    public function store(CreateUserDTO $userDTO, CreateEngineerDTO $engineerDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $engineerDTO) {
            $user = $this->userDAO->store($userDTO);
            $engineerDTO->user_id = $user->id;

            $this->userDAO->verify($user);

            $this->engineerDAO->store($engineerDTO);

            return $user;
        });
    }

    public function show($id)
    {
        $engineer = $this->engineerDAO->show($id);
        return $engineer->user;
    }

    public function update(int $id, UpdateUserDTO $userDTO, UpdateEngineerDTO $engineerDTO)
    {
        return $this->transaction->execute(function () use ($id, $userDTO, $engineerDTO) {
            $user = $this->show($id);
            $engineer = $user->engineer;
            $this->userDAO->update($user, $userDTO);
            $this->engineerDAO->update($engineer, $engineerDTO);
            return $user;
        });
    }

    public function destroy($id)
    {
        return $this->engineerDAO->destroy($id);
    }
}
