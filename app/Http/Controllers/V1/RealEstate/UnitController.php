<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateUnitDTO;
use App\DTOs\RealEstate\Update\UpdateUnitDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateUnitRequest;
use App\Services\RealEstate\UnitService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private UnitService $unitService
    ) {}

    public function index(int $building_id)
    {
        $units = $this->unitService->index($building_id);
        return $this->successResponse($units);
    }

    public function store(CreateUnitRequest $request)
    {
        $unitDTO = CreateUnitDTO::fromRequest($request->validated());
        $unit = $this->unitService->store($unitDTO);
        return $this->successResponse($unit, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $unit = $this->unitService->show($id);
        return $this->successResponse($unit);
    }

    public function update(int $id, Request $request)
    {
        $unitDTO = UpdateUnitDTO::fromRequest($request->all());
        $unit = $this->unitService->update($id, $unitDTO);
        return $this->successResponse($unit, __('messages.common.updated'));
    }

    public function destroy($id)
    {
        $this->unitService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
