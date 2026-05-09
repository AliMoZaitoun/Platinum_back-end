<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateBuildingDTO;
use App\DTOs\RealEstate\Update\UpdateBuildingDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateBuildingRequest;
use App\Http\Resources\V1\RealEstate\BuildingResource;
use App\Services\RealEstate\BuildingService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

/**
 * @method void authorize(mixed $ability, mixed|array $arguments = [])
 */

class BuildingController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private BuildingService $buildingService
    ) {}

    public function index(int $project_id)
    {
        $this->authorize('view');
        $buildings = $this->buildingService->index($project_id);

        return $this->successCollection($buildings, BuildingResource::class);
    }

    public function store(CreateBuildingRequest $request)
    {
        $this->authorize('create');
        $buildingDTO = CreateBuildingDTO::fromRequest($request->validated());
        $building = $this->buildingService->store($buildingDTO);
        return $this->useResource($building, BuildingResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $this->authorize('view');
        $building = $this->buildingService->show($id);
        return $this->useResource($building, BuildingResource::class);
    }

    public function update(int $id, Request $request)
    {
        $this->authorize('update');
        $buildingDTO = UpdateBuildingDTO::fromRequest($request->all());
        $building = $this->buildingService->update($id, $buildingDTO);
        return $this->useResource($building, BuildingResource::class, __('messages.common.updated'), 200);
    }

    public function destroy(int $id)
    {
        $this->authorize('delete');
        $this->buildingService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
