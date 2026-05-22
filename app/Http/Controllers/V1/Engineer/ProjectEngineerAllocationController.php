<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\Engineer\Create\AssignEngineerAllocationDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\StoreProjectEngineerAllocationRequest;
use App\Http\Resources\V1\Engineer\ProjectEngineerAllocationResource;
use App\Http\Resources\V1\Core\ProjectEngineerAllocationResourceForAdmin;
use App\Services\Engineer\ProjectEngineerAllocationService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProjectEngineerAllocationController extends Controller
{
    use ResponseTrait;

    public function __construct(private ProjectEngineerAllocationService $allocationService) {}

    public function index()
    {
        $engPros = $this->allocationService->index();
        return $this->successCollection($engPros, ProjectEngineerAllocationResource::class);
    }

    public function store(StoreProjectEngineerAllocationRequest $request)
    {
        $dto = AssignEngineerAllocationDTO::fromRequest($request->validated());
        $this->allocationService->store($dto);
        return $this->successResponse([], __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $projectEng = $this->allocationService->show($id);
        return $this->useResource($projectEng, ProjectEngineerAllocationResource::class);
    }

    public function myLocations()
    {
        $engineer = request()->user()->engineer;
        $allocations = $this->allocationService->engineerAllocations($engineer->id);

        return $this->successCollection($allocations, ProjectEngineerAllocationResource::class);
    }

    public function engineerAllocations(int $engineer_id)
    {
        $allocations = $this->allocationService->engineerAllocations($engineer_id);

        return $this->successCollection($allocations, ProjectEngineerAllocationResource::class);
    }

    public function getEngineersAllocatedToProject(int $project_id)
    {
        $engineers = $this->allocationService->getEngineersAllocatedToProject($project_id);

        return $this->successCollection($engineers, ProjectEngineerAllocationResourceForAdmin::class);
    }

    public function getEngineersAllocatedToBuilding(int $building_id)
    {
        $engineers = $this->allocationService->getEngineersAllocatedToBuilding($building_id);

        return $this->successCollection($engineers, ProjectEngineerAllocationResourceForAdmin::class);
    }

    public function update(int $id, Request $request)
    {
        $dto = UpdateEngProDTO::fromRequest($request->all());
        $location = $this->allocationService->update($id, $dto);
        return $this->useResource($location, ProjectEngineerAllocationResource::class, __('messages.common.updated'), 200);
    }

    public function destroy(int $id)
    {
        $this->allocationService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
