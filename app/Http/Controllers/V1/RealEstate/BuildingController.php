<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateBuildingDTO;
use App\DTOs\RealEstate\Update\UpdateBuildingDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateBuildingRequest;
use App\Services\RealEstate\BuildingService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private BuildingService $buildingService
    ) {}

    public function index(int $project_id)
    {
        $buildings = $this->buildingService->index($project_id);
        return $this->successResponse($buildings);
    }

    public function store(CreateBuildingRequest $request)
    {
        $buildingDTO = CreateBuildingDTO::fromRequest($request->validated());
        $building = $this->buildingService->store($buildingDTO);
        return $this->successResponse($building, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $building = $this->buildingService->show($id);
        return $this->successResponse($building);
    }

    public function update(int $id, Request $request)
    {
        $buildingDTO = UpdateBuildingDTO::fromRequest($request->all());
        $building = $this->buildingService->update($id, $buildingDTO);
        return $this->successResponse($building, __('messages.common.updated'), 200);
    }

    public function destroy($id)
    {
        $this->buildingService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
