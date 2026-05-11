<?php

namespace App\Services\Client;

use App\DAO\Client\ClientDAO;
use App\DAO\UserDAO;
use App\DTOs\Client\Update\UpdateClientDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\Client\Create\CreateClientDTO;
use App\DTOs\User\Create\CreateUserDTO;
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

    public function show(int $id)
    {
        return $this->clientDAO->show($id);
    }

    public function update(int $id, UpdateUserDTO $userDTO, UpdateClientDTO $clientDTO)
    {
        return $this->transaction->execute(function () use ($id, $userDTO, $clientDTO) {
            $client = $this->show($id);
            $user = $client->user;
            $this->userDAO->update($user, $userDTO);
            $this->clientDAO->update($client, $clientDTO);
            return $user;
        });
    }

    public function destroy(int $id)
    {
        return $this->clientDAO->destroy($id);
    }
}
