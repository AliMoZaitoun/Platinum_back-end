<?php

namespace App\Services\Engineer;

use App\DAO\Engineer\EngineerDAO;
use App\DAO\UserDAO;
use App\DTOs\Engineer\Update\UpdateEngineerDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\Engineer\Create\CreateEngineerDTO;
use App\DTOs\User\Create\CreateUserDTO;
use App\Exceptions\NotFoundException;
use App\Services\Transaction;

class EngineerService
{

    public function __construct(
        private EngineerDAO $engineerDAO,
        private UserDAO $userDAO,
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

    public function show(int $id)
    {
        return $this->engineerDAO->show($id);
    }

    public function update(int $id, UpdateUserDTO $userDTO, UpdateEngineerDTO $engineerDTO)
    {
        return $this->transaction->execute(function () use ($id, $userDTO, $engineerDTO) {
            $engineer = $this->show($id);
            $this->userDAO->update($engineer->user->id, $userDTO);
            $this->engineerDAO->update($id, $engineerDTO);
            $engineer->refresh();
            return $engineer;
        });
    }

    public function destroy(int $id)
    {
        return $this->engineerDAO->destroy($id);
    }
}
