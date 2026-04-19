<?php

namespace App\DAO\Client;

use App\DTOs\User\Update\UpdateClientDTO;
use App\DTOs\User\CreateClientDTO;
use App\Exceptions\NotFoundException;
use App\Models\Client;

class ClientDAO
{
    public function index()
    {
        return Client::all();
    }

    public function store(CreateClientDTO $clientDTO)
    {
        $client = Client::create($clientDTO->toArray());
        $client->user->assignRole('client');
        return $client;
    }

    public function show($id)
    {
        return Client::find($id) ?? throw new NotFoundException("Client");
    }

    public function update($client, UpdateClientDTO $clientDTO)
    {
        return $client->update($clientDTO->toArray());
    }

    public function destroy($id)
    {
        $client = $this->show($id);
        return $client->user->delete();
    }
}
