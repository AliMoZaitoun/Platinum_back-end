<?php

namespace App\DAO\Core;

use App\DTOs\Core\CreateWarehouseDTO;
use App\DTOs\Core\Update\UpdateWarehouseDTO;
use App\Exceptions\NotFoundException;
use App\Models\Warehouse;

class WarehouseDAO
{
    public function index()
    {
        return Warehouse::all();
    }

    public function store(CreateWarehouseDTO $warehouseDTO)
    {
        return Warehouse::create($warehouseDTO->toArray());
    }

    public function show(int $id)
    {
        return Warehouse::find($id) ?? throw new NotFoundException('Warehouse');
    }

    public function update(int $id, UpdateWarehouseDTO $warehouseDTO)
    {
        $warehouse = $this->show($id);
        return $warehouse->update($warehouseDTO->toArray());
    }

    public function destroy(int $id)
    {
        $warehouse = $this->show($id);
        return $warehouse->delete();
    }
}
