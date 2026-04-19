<?php

namespace App\Http\Controllers\V1\Client;

use App\DTOs\User\CreateClientDTO;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\Update\UpdateClientDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Client\ClientRequest;
use App\Services\User\ClientService;
use App\Traits\ProvidesUserResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use ResponseTrait, ProvidesUserResource;

    public function __construct(
        private ClientService $clientService
    ) {}

    public function index()
    {
        $clients = $this->clientService->index();
        return $this->successResponse($clients, __('messages.common.success'), 200);
    }

    public function store(ClientRequest $clientRequest)
    {
        $userDTO = CreateUserDTO::fromRequest($clientRequest->validated(), 'client');

        $clientDTO = CreateClientDTO::fromRequest($clientRequest->validated());

        $user = $this->clientService->store($userDTO, $clientDTO);

        // $user = $this->resolveUserResource($user);

        // For Testing
        $user = $this->resolveUserResource($user['user']);

        return $this->successResponse($user, __('messages.auth.otp_sent'), 201);
    }

    public function show($id)
    {
        $client = $this->clientService->show($id);
        $user = $this->resolveUserResource($client);
        return $this->successResponse($user, __('messages.common.success'), 200);
    }

    public function update(int $id, Request $request)
    {
        $userDTO = UpdateUserDTO::fromRequest($request->all());

        $clientDTO = UpdateClientDTO::fromRequest($request->all());

        $user = $this->clientService->update($id, $userDTO, $clientDTO);
        $user = $this->resolveUserResource($user);
        return $this->successResponse($user, __('messages.common.updated'));
    }

    public function destroy($id)
    {
        $this->clientService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
