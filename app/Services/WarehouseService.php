<?php

namespace App\Services;

use App\DAO\Basics\WarehouseDAO;
use App\DTOs\Basics\CreateWarehouseDTO;
use App\DTOs\Basics\Update\UpdateWarehouseDTO;
use App\Exceptions\NotFoundException;

class WarehouseService
{
    public function __construct(
        private WarehouseDAO $warehouseDAO
    ) {}

    public function createWarehouse(CreateWarehouseDTO $warehouseDTO)
    {
        return $this->warehouseDAO->createWarehouse($warehouseDTO);
    }

    public function getAllWarehouses()
    {
        return $this->warehouseDAO->getAll();
    }

    public function getWarehouseById(int $id)
    {
        return $this->findOrFail($id);
    }

    private function findOrFail(int $id)
    {
        return $this->warehouseDAO->getById($id) ?? throw new NotFoundException('Warehouse');
    }

    public function updateWarehouse(UpdateWarehouseDTO $warehouseDTO)
    {
        return $this->warehouseDAO->update($this->findOrFail($warehouseDTO->id), $warehouseDTO);
    }

    public function deleteWarehouse(int $id)
    {
        return $this->warehouseDAO->delete($this->findOrFail($id));
    }
}
