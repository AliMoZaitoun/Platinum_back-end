<?php

namespace App\DAO\Basics;

use App\DTOs\Basics\CreateWarehouseDTO;
use App\DTOs\Basics\Update\UpdateWarehouseDTO;
use App\Models\Warehouse;

class WarehouseDAO
{
    public function createWarehouse(CreateWarehouseDTO $warehouseDTO)
    {
        return Warehouse::create($warehouseDTO->toArray());
    }

    public function getAll()
    {
        return Warehouse::all();
    }

    public function getById(int $id)
    {
        return Warehouse::find($id);
    }

    public function update(Warehouse $warehouse, UpdateWarehouseDTO $warehouseDTO)
    {
        return $warehouse->update(array_filter($warehouseDTO->toArray(), fn($v) => !is_null($v)));
    }

    public function delete(Warehouse $warehouse)
    {
        return $warehouse->delete();
    }
}
