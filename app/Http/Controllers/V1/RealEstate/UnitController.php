<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateUnitDTO;
use App\DTOs\RealEstate\Update\UpdateUnitDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateUnitRequest;
use App\Http\Resources\V1\RealEstate\UnitResource;
use App\Services\RealEstate\UnitService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private UnitService $unitService
    ) {}

    public function index()
    {
        $units = $this->unitService->index();
        return $this->successCollection($units, UnitResource::class);
    }

    public function byBuilding(int $building_id)
    {
        $units = $this->unitService->byBuilding($building_id, []);
        return $this->successCollection($units, UnitResource::class);
    }

    public function store(CreateUnitRequest $request)
    {
        $unitDTO = CreateUnitDTO::fromRequest($request->validated());
        $unit = $this->unitService->store($unitDTO);
        return $this->useResource($unit, UnitResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $unit = $this->unitService->show($id);
        return $this->useResource($unit, UnitResource::class);
    }

    public function search(Request $request)
    {
        $units = $this->unitService->search($request->all());
        return $this->successCollection($units, UnitResource::class);
    }

    public function update(int $id, Request $request)
    {
        $unitDTO = UpdateUnitDTO::fromRequest($request->all());
        $unit = $this->unitService->update($id, $unitDTO);
        return $this->useResource($unit, UnitResource::class, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->unitService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
