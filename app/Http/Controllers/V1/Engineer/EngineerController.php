<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\Engineer\Update\UpdateEngineerDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\DTOs\Engineer\Create\CreateEngineerDTO;
use App\DTOs\User\Create\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\EngineerRequest;
use App\Http\Resources\V1\EngineerDetailResource;
use App\Services\Engineer\EngineerService;
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
        return $this->successUserCollection($engineers);
    }

    public function store(EngineerRequest $engineerRequest)
    {
        $userDTO = CreateUserDTO::fromRequest($engineerRequest->validated(), 'engineer');

        $engineerDTO = CreateEngineerDTO::fromRequest($engineerRequest->validated());

        $engineer = $this->engineerService->store($userDTO, $engineerDTO);

        return $this->useResource($engineer, EngineerDetailResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $engineer = $this->engineerService->show($id);
        return $this->useResource($engineer, EngineerDetailResource::class);
    }

    public function update(Request $request)
    {
        $userDTO = UpdateUserDTO::fromRequest($request->all());

        $engineerDTO = UpdateEngineerDTO::fromRequest($request->all());

        $engineer = $request->user()->engineer;
        $engineer = $this->engineerService->update($engineer->id, $userDTO, $engineerDTO);

        $data['user'] = $this->resolveUserResource($engineer->user);
        return $this->successResponse($data, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->engineerService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
