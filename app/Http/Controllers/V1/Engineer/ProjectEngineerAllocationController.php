<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\Engineer\Create\AssignEngineerAllocationDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\StoreProjectEngineerAllocationRequest;
use App\Http\Resources\V1\Core\ProjectEngineerAllocationResource;
use App\Services\Engineer\ProjectEngineerAllocationService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProjectEngineerAllocationController extends Controller
{
    use ResponseTrait;

    public function __construct(private ProjectEngineerAllocationService $engProService) {}

    public function index()
    {
        $engPros = $this->engProService->index();
        return $this->successCollection($engPros, ProjectEngineerAllocationResource::class);
    }

    public function store(StoreProjectEngineerAllocationRequest $request)
    {
        $dto = AssignEngineerAllocationDTO::fromRequest($request->validated());
        $projectEng = $this->engProService->store($dto);
        return $this->useResource($projectEng, ProjectEngineerAllocationResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $projectEng = $this->engProService->show($id);
        return $this->useResource($projectEng, ProjectEngineerAllocationResource::class);
    }

    public function myProjects()
    {
        $projects = $this->engProService->myProjects();
        return $this->successCollection($projects, ProjectEngineerAllocationResource::class);
    }

    public function engProjects(int $engineer_id)
    {
        // Gate::authorize('view');

        $projects = $this->engProService->engProjects($engineer_id);
        return $this->successCollection($projects, ProjectEngineerAllocationResource::class);
    }

    public function proEngineers(int $project_id)
    {
        // Gate::authorize('view');

        $engineers = $this->engProService->proEngineers($project_id);
        return $this->successCollection($engineers, ProjectEngineerAllocationResource::class);
    }

    public function update(int $id, Request $request)
    {
        $dto = UpdateEngProDTO::fromRequest($request->all());
        $location = $this->engProService->update($id, $dto);
        return $this->useResource($location, ProjectEngineerAllocationResource::class, __('messages.common.updated'), 200);
    }

    public function destroy(int $id)
    {
        $this->engProService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
