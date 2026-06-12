<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateSolutionDTO;
use App\DTOs\RealEstate\Update\UpdateSolutionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateSolutionRequest;
use App\Http\Resources\V1\RealEstate\SolutionResource;
use App\Services\RealEstate\SolutionService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private SolutionService $solutionService
    ) {}


    public function index()
    {
        $solutions = $this->solutionService->index();
        return $this->successCollection($solutions, SolutionResource::class);
    }

    public function store(CreateSolutionRequest $request)
    {
        $solutionDTO = CreateSolutionDTO::fromRequest($request->validated());

        $solution = $this->solutionService->store($solutionDTO, $request->file('attachments'));
        return $this->useResource($solution, SolutionResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $solution = $this->solutionService->show($id);
        return $this->useResource($solution, SolutionResource::class);
    }

    public function update(int $id, Request $request)
    {
        $solutionDTO = UpdateSolutionDTO::fromRequest($request->all());

        $solution = $this->solutionService->update($id, $solutionDTO);
        return $this->useResource($solution, SolutionResource::class, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->solutionService->destroy($id);
        return $this->successResponse(null, __('messages.common.deleted'));
    }
}
