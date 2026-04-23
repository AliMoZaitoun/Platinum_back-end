<?php

namespace App\Http\Controllers\V1;

use App\DTOs\User\Update\UpdateEngineerDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\User\CreateEngineerDTO;
use App\DTOs\User\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EngineerRequest;
use App\Services\User\EngineerService;
use App\Traits\ProvidesUserResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EngineerController extends Controller
{
    use ResponseTrait, ProvidesUserResource;

    public function __construct(
        private EngineerService $engineerService
    ) {}

    public function index()
    {
        $engineers = $this->engineerService->index();
        return $this->successCollection($engineers);
    }

    public function store(EngineerRequest $engineerRequest)
    {
        $userDTO = CreateUserDTO::fromRequest($engineerRequest->validated(), 'engineer');

        $engineerDTO = CreateEngineerDTO::fromRequest($engineerRequest->validated());

        $user = $this->engineerService->store($userDTO, $engineerDTO);

        $user = $this->resolveUserResource($user);

        return $this->successResponse($user, __('messages.common.stored'), 201);
    }

    public function show($id)
    {
        $engineer = $this->engineerService->show($id);
        $user = $this->resolveUserResource($engineer);
        return $this->successResponse($user);
    }

    public function update(int $id, Request $request)
    {
        $userDTO = UpdateUserDTO::fromRequest($request->all());

        $engineerDTO = UpdateEngineerDTO::fromRequest($request->all());

        $engineer = $this->engineerService->update($id, $userDTO, $engineerDTO);
        return $this->successResponse($engineer, __('messages.common.updated'));
    }

    public function destroy($id)
    {
        $this->engineerService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
