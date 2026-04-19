<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateProjectRequest;
use App\Services\RealEstate\ProjectService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private ProjectService $projectService
    ) {}

    public function index()
    {
        $projects = $this->projectService->index();
        return $this->successResponse($projects);
    }

    public function store(CreateProjectRequest $request)
    {
        $projectDTO = CreateProjectDTO::fromRequest($request->validated());
        $project = $this->projectService->store($projectDTO);
        return $this->successResponse($project, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $project = $this->projectService->show($id);
        return $this->successResponse($project);
    }

    public function update(int $id, Request $request)
    {
        $projectDTO = UpdateProjectDTO::fromRequest($request->all());
        $project = $this->projectService->update($id, $projectDTO);
        return $this->successResponse($project, __('messages.common.updated'), 200);
    }

    public function destroy($id)
    {
        $this->projectService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
