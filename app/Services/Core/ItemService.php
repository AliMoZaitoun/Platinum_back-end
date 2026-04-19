<?php

namespace App\Services\Core;

use App\DAO\Core\ItemDAO;
use App\DTOs\Core\CreateItemDTO;
use App\DTOs\Core\Update\UpdateItemDTO;

class ItemService
{
    public function __construct(
        private ItemDAO $itemDAO
    ) {}

    public function index()
    {
        return $this->itemDAO->index();
    }

    public function store(CreateItemDTO $itemDTO)
    {
        return $this->itemDAO->store($itemDTO);
    }

    public function show($id)
    {
        return $this->itemDAO->show($id);
    }

    public function getItemsByWarehouseID(int $warehouseID)
    {
        return $this->itemDAO->getItemsByWarehouseID($warehouseID);
    }

    public function update(int $id, UpdateItemDTO $itemDTO)
    {
        return $this->itemDAO->update($id, $itemDTO);
    }

    public function destroy(int $id)
    {
        return $this->itemDAO->destroy($id);
    }
}
