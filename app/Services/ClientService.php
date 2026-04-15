<?php

namespace App\Services;

use App\DAO\ClientDAO;
use App\DAO\OtpCodeDAO;
use App\DAO\UserDAO;
use App\DTOs\User\Update\UpdateClientDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateClientDTO;
use App\DTOs\User\CreateUserDTO;
use Illuminate\Support\Facades\Auth;

class ClientService
{
    public function __construct(
        private ClientDAO $clientDAO,
        private UserDAO $userDAO,
        private OtpService $otpService,
        private Transaction $transaction
    ) {}

    public function createClient(CreateUserDTO $userDTO, CreateClientDTO $clientDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $clientDTO) {
            $user = $this->userDAO->store($userDTO);
            $clientDTO->user_id = $user->id;
            $this->otpService->createCode($user->id);
            return $this->clientDAO->store($clientDTO);
        });
    }

    public function getClient($id)
    {
        // Logic to retrieve a client by ID
    }

    public function updateClient(UpdateUserDTO $userDTO, UpdateClientDTO $clientDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $clientDTO) {
            $user = Auth::user();
            $client = $user->client;
            $this->userDAO->update($user, $userDTO);
            return $this->clientDAO->update($client, $clientDTO);
        });
    }
}
