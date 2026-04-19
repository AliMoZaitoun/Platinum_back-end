<?php

namespace App\Services\User;

use App\DAO\Client\ClientDAO;
use App\DAO\User\UserDAO;
use App\DTOs\User\Update\UpdateClientDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateClientDTO;
use App\DTOs\User\CreateUserDTO;
use App\Events\V1\OTPEvent;
use App\Exceptions\NotFoundException;
use App\Services\OtpService;
use App\Services\Transaction;

class ClientService
{
    public function __construct(
        private ClientDAO $clientDAO,
        private UserDAO $userDAO,
        private OtpService $otpService,
        private Transaction $transaction
    ) {}

    public function index()
    {
        $clients = $this->clientDAO->index();
        if (sizeof($clients) <= 0)
            throw new NotFoundException("Clients");
        return $clients;
    }

    public function store(CreateUserDTO $userDTO, CreateClientDTO $clientDTO)
    {
        return $this->transaction->execute(function () use ($userDTO, $clientDTO) {
            $user = $this->userDAO->store($userDTO);
            $clientDTO->user_id = $user->id;

            $this->clientDAO->store($clientDTO);

            $code = $this->otpService->createCode($user->id);
            // event(new OTPEvent($code, $user->email));

            // For Testing
            return ['user' => $user, 'otp' => $code];
        });
    }

    public function show($id)
    {
        $client = $this->clientDAO->show($id);
        return $client->user;
    }

    public function update(int $id, UpdateUserDTO $userDTO, UpdateClientDTO $clientDTO)
    {
        return $this->transaction->execute(function () use ($id, $userDTO, $clientDTO) {
            $user = $this->show($id);
            $client = $user->client;
            $this->userDAO->update($user, $userDTO);
            $this->clientDAO->update($client, $clientDTO);
            return $user;
        });
    }

    public function destroy($id)
    {
        return $this->clientDAO->destroy($id);
    }
}
