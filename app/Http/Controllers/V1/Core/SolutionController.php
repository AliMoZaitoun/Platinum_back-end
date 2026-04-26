<?php

namespace App\Http\Controllers\V1\Core;

use App\DTOs\Core\CreateSolutionDTO;
use App\DTOs\Core\Update\UpdateSolutionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateSolutionRequest;
use App\Services\Core\SolutionService;
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
        return $this->successResponse($solutions, "Solutions retrieved successfully.");
    }

    public function store(CreateSolutionRequest $request)
    {
        $solutionDTO = CreateSolutionDTO::fromRequest($request->validated());

        $solution = $this->solutionService->store($solutionDTO);
        return $this->successResponse($solution, __('messages.common.stored'), 201);
    }

    public function show($id)
    {
        $solution = $this->solutionService->show($id);
        return $this->successResponse($solution, "Solution retrieved successfully.");
    }

    public function update($id, Request $request)
    {
        $solutionDTO = UpdateSolutionDTO::fromRequest($request->all());

        $solution = $this->solutionService->update($id, $solutionDTO);
        return $this->successResponse($solution, __('messages.common.updated'));
    }

    public function destroy($id)
    {
        $this->solutionService->destroy($id);
        return $this->successResponse(null, __('messages.common.deleted'));
    }
}
