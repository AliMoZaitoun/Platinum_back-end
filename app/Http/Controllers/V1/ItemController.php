<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Basics\CreateItemDTO;
use App\DTOs\Basics\Update\UpdateItemDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddItemRequest;
use App\Services\ItemService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ItemService $itemService
    ) {}

    public function addItem(AddItemRequest $addItemRequest)
    {
        $itemDTO = new CreateItemDTO(
            id: null,
            warehouseID: $addItemRequest->input('warehouse_id'),
            sku: $addItemRequest->input('sku'),
            name: $addItemRequest->input('name'),
            description: $addItemRequest->input('description'),
            quantity: $addItemRequest->input('quantity'),
            status: $addItemRequest->input('status'),
            expiry_date: $addItemRequest->input('expiry_date'),
            purchase_date: $addItemRequest->input('purchase_date'),
            received_date: $addItemRequest->input('received_date'),
        );
        $item = $this->itemService->addItem($itemDTO);
        return $this->successResponse($item, 'Item created successfully.');
    }

    public function getItemsByWarehouseID($warehouse_id)
    {
        $items = $this->itemService->getItemsByWarehouseID($warehouse_id);
        return $this->successResponse($items, 'Items retrieved successfully.');
    }

    public function getAllItems()
    {
        $items = $this->itemService->getAllItems();
        return $this->successResponse($items, 'Items retrieved successfully.');
    }

    public function getItemByID($item_id)
    {
        $item = $this->itemService->getItemByID($item_id);
    }

    public function updateItem($item_id, Request $request)
    {
        $itemDTO = new UpdateItemDTO(
            id: $item_id,
            sku: $request->input('sku'),
            name: $request->input('name'),
            description: $request->input('description'),
            quantity: $request->input('quantity'),
            status: $request->input('status'),
            expiry_date: $request->input('expiry_date'),
            purchase_date: $request->input('purchase_date'),
            received_date: $request->input('received_date'),
        );
        $updatedItem = $this->itemService->updateItem($item_id, $itemDTO);
        return $this->successResponse($updatedItem, 'Item updated successfully.');
    }

    public function deleteItem($item_id)
    {
        $this->itemService->deleteItem($item_id);
        return $this->successResponse(null, 'Item deleted successfully.');
    }
}
