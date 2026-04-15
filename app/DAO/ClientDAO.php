<?php

namespace App\DAO;

use App\DTOs\User\Update\UpdateClientDTO;
use App\DTOs\User\CreateClientDTO;
use App\Models\Client;

class ClientDAO
{
    public function store(CreateClientDTO $clientDTO)
    {
        return Client::create([
            'user_id' => $clientDTO->user_id,
            'birth_date' => $clientDTO->birth_date,
            'job_title' => $clientDTO->job_title,
            'social_status' => $clientDTO->social_status,
            'national_id' => $clientDTO->national_id
        ]);
    }

    public function find($id)
    {
        return Client::find($id);
    }

    public function update($client, UpdateClientDTO $clientDTO)
    {
        $client->update([
            'birth_date' => $clientDTO->birth_date ?? $client->birth_date,
            'job_title' => $clientDTO->job_title ?? $client->job_title,
            'social_status' => $clientDTO->social_status ?? $client->social_status,
            'national_id' => $clientDTO->national_id ?? $client->national_id
        ]);
        return $client;
    }

    public function delete($id)
    {
        // Logic to delete a client from the database
    }
}
