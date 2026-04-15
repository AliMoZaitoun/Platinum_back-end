<?php

namespace App\Services;

use App\DAO\Basics\ItemDAO;
use App\DTOs\Basics\CreateItemDTO;
use App\DTOs\Basics\Update\UpdateItemDTO;
use App\Exceptions\NotFoundException;

class ItemService
{
    public function __construct(
        private ItemDAO $itemDAO
    ) {}

    public function addItem(CreateItemDTO $itemDTO)
    {
        return $this->itemDAO->createItem($itemDTO);
    }

    private function findOrFail(int $id)
    {
        return $this->itemDAO->getItemById($id) ?? throw new NotFoundException("Item");
    }

    public function getItemByID($itemID)
    {
        return $this->findOrFail($itemID);
    }

    public function getAllItems()
    {
        return $this->itemDAO->getItems();
    }

    public function getItemsByWarehouseID(int $warehouseID)
    {
        return $this->itemDAO->getItemsByWarehouseID($warehouseID);
    }

    public function updateItem(int $id, UpdateItemDTO $itemDTO)
    {
        $item = $this->findOrFail($id);
        return $this->itemDAO->updateItem($item, $itemDTO);
    }

    public function deleteItem(int $id)
    {
        $item = $this->findOrFail($id);
        return $this->itemDAO->deleteItem($item);
    }
}
