<?php

namespace App\DAO\Basics;

use App\DTOs\Basics\CreateItemDTO;
use App\DTOs\Basics\Update\UpdateItemDTO;
use App\Models\Item;

class ItemDAO
{

    public function createItem(CreateItemDTO $itemDTO)
    {
        return Item::create($itemDTO->toArray());
    }

    public function getItems()
    {
        return Item::all();
    }

    public function getItemsByWarehouseID($warehouse_id)
    {
        return Item::where('warehouse_id', $warehouse_id)->get();
    }

    public function getItemById(int $id)
    {
        return Item::find($id);
    }

    public function updateItem(Item $item, UpdateItemDTO $itemDTO)
    {
        return $item->update(array_filter($itemDTO->toArray(), fn($v) => !is_null($v)));
    }

    public function deleteItem(Item $item)
    {
        return $item->delete();
    }
}
