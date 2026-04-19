<?php

namespace App\Http\Controllers\V1\Core;

use App\DTOs\Core\CreateWarehouseDTO;
use App\DTOs\Core\Update\UpdateWarehouseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\CreateWarehouseRequest;
use App\Services\Core\WarehouseService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private WarehouseService $warehousesService
    ) {}

    public function index()
    {
        $warehouses = $this->warehousesService->index();
        return $this->successResponse($warehouses);
    }

    public function store(CreateWarehouseRequest $request)
    {
        $warehouseDTO = CreateWarehouseDTO::fromRequest($request->validated());
        $warehouse = $this->warehousesService->store($warehouseDTO);

        return $this->successResponse($warehouse, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $warehouse = $this->warehousesService->show($id);
        return $this->successResponse($warehouse);
    }

    public function update(int $id, Request $request)
    {
        $warehouseDTO = UpdateWarehouseDTO::fromRequest($request->all());
        $warehouse = $this->warehousesService->update($id, $warehouseDTO);
        return $this->successResponse($warehouse, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->warehousesService->destroy($id);
        return $this->successResponse(null, __('messages.common.deleted'));
    }
}
