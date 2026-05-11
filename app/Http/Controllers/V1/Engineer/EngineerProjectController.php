<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\Engineer\Create\AssignEngProDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\AssignEngineerProjectRequest;
use App\Http\Resources\V1\Core\EngineerProjectResource;
use App\Services\RealEstate\EngineerProjectService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EngineerProjectController extends Controller
{
    use ResponseTrait;

    public function __construct(private EngineerProjectService $engProService) {}

    public function index()
    {
        $engPros = $this->engProService->index();
        return $this->successCollection($engPros, EngineerProjectResource::class);
    }

    public function store(AssignEngineerProjectRequest $request)
    {
        $dto = AssignEngProDTO::fromRequest($request->validated());
        $projectEng = $this->engProService->store($dto);
        return $this->useResource($projectEng, EngineerProjectResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $projectEng = $this->engProService->show($id);
        return $this->useResource($projectEng, EngineerProjectResource::class);
    }

    public function myProjects()
    {
        $projects = $this->engProService->myProjects();
        return $this->successCollection($projects, EngineerProjectResource::class);
    }

    public function engProjects(int $engineer_id)
    {
        $projects = $this->engProService->engProjects($engineer_id);
        return $this->successCollection($projects, EngineerProjectResource::class);
    }

    public function proEngineers(int $project_id)
    {
        $engineers = $this->engProService->proEngineers($project_id);
        return $this->successCollection($engineers, EngineerProjectResource::class);
    }

    public function update(int $id, Request $request)
    {
        $dto = UpdateEngProDTO::fromRequest($request->all());
        $location = $this->engProService->update($id, $dto);
        return $this->useResource($location, EngineerProjectResource::class, __('messages.common.updated'), 200);
    }

    public function destroy(int $id)
    {
        $this->engProService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
