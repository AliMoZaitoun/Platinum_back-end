<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Basics\CreateWarehouseDTO;
use App\DTOs\Basics\Update\UpdateWarehouseDTO;
use App\Http\Controllers\Controller;
use App\Services\WarehouseService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private WarehouseService $warehousesService
    ) {}

    public function createWarehouse(Request $request)
    {
        $warehouseDTO = new CreateWarehouseDTO(
            id: null,
            name: $request->input('name'),
            location: $request->input('location'),
        );
        $warehouse = $this->warehousesService->createWarehouse($warehouseDTO);

        return $this->successResponse($warehouse, "Warehouse created successfully", 201);
    }

    public function getAllWarehouses()
    {
        $warehouses = $this->warehousesService->getAllWarehouses();
        return $this->successResponse($warehouses, "Warehouses retrieved successfully");
    }

    public function getWarehouseById(int $warehouse_id)
    {
        $warehouse = $this->warehousesService->getWarehouseById($warehouse_id);
        return $this->successResponse($warehouse, "Warehouse retrieved successfully");
    }

    public function updateWarehouse($warehouse_id, Request $request)
    {
        $warehouseDTO = new UpdateWarehouseDTO(
            id: $warehouse_id,
            name: $request->input('name'),
            location: $request->input('location'),
        );
        $warehouse = $this->warehousesService->updateWarehouse($warehouseDTO);
        return $this->successResponse($warehouse, "Warehouse updated successfully");
    }

    public function deleteWarehouse($warehouse_id)
    {
        $this->warehousesService->deleteWarehouse($warehouse_id);
        return $this->successResponse(null, "Warehouse deleted successfully");
    }
}
