<?php

namespace App\Http\Controllers\V1;

use App\DTOs\User\CreateClientDTO;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\Update\UpdateClientDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ClientRequest;
use App\Services\ClientService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ClientController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ClientService $clientService
    ) {}

    public function registerClient(ClientRequest $clientRequest)
    {
        $userDTO = CreateUserDTO::fromRequest($clientRequest->all(), 'client');

        $clientDTO = new CreateClientDTO(
            id: null,
            user_id: null,
            birth_date: new \DateTime($clientRequest->input('birth_date')),
            job_title: $clientRequest->input('job_title'),
            social_status: $clientRequest->input('social_status'),
            national_id: $clientRequest->input('national_id')
        );

        $data = $this->clientService->createClient($userDTO, $clientDTO);
        return $this->successResponse($data, 'Client created successfully.', 201);
    }

    public function getClient($id)
    {
        // Logic to retrieve a client by ID
    }

    public function updateClient(Request $request)
    {
        $userDTO = new UpdateUserDTO(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            address: $request->input('address'),
            phone: $request->input('phone'),
            email: $request->input('email')
        );

        $clientDTO = new UpdateClientDTO(
            id: null,
            user_id: null,
            birth_date: $request->input('birth_date'),
            job_title: $request->input('job_title'),
            social_status: $request->input('social_status'),
            national_id: $request->input('national_id')
        );
        $client = $this->clientService->updateClient($userDTO, $clientDTO);
        return $this->successResponse($client, 'Client updated successfully');
    }
}
