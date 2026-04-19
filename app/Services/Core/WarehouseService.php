<?php

namespace App\Services\Core;

use App\DAO\Core\WarehouseDAO;
use App\DTOs\Core\CreateWarehouseDTO;
use App\DTOs\Core\Update\UpdateWarehouseDTO;

class WarehouseService
{
    public function __construct(
        private WarehouseDAO $warehouseDAO
    ) {}

    public function store(CreateWarehouseDTO $warehouseDTO)
    {
        return $this->warehouseDAO->store($warehouseDTO);
    }

    public function index()
    {
        return $this->warehouseDAO->index();
    }

    public function show(int $id)
    {
        return $this->warehouseDAO->show($id);
    }

    public function update(int $id, UpdateWarehouseDTO $warehouseDTO)
    {
        return $this->warehouseDAO->update($id, $warehouseDTO);
    }

    public function destroy(int $id)
    {
        return $this->warehouseDAO->destroy($id);
    }
}
