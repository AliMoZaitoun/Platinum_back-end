<?php

namespace App\Http\Controllers\V1\Core;

use App\DTOs\Core\CreateItemDTO;
use App\DTOs\Core\Update\UpdateItemDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\CreateItemRequest;
use App\Services\Core\ItemService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ItemService $itemService
    ) {}

    public function index()
    {
        $items = $this->itemService->index();
        return $this->successResponse($items);
    }

    public function store(CreateItemRequest $addItemRequest)
    {
        $itemDTO = CreateItemDTO::fromRequest($addItemRequest->validated());

        $item = $this->itemService->store($itemDTO);
        return $this->successResponse($item, __('messages.common.stored'), 201);
    }

    public function getItemsByWarehouseID($warehouse_id)
    {
        $items = $this->itemService->getItemsByWarehouseID($warehouse_id);
        return $this->successResponse($items);
    }

    public function show(int $id)
    {
        $item = $this->itemService->show($id);
        return $this->successResponse($item);
    }

    public function update(int $id, Request $request)
    {
        $itemDTO = UpdateItemDTO::fromRequest($request->all());

        $updatedItem = $this->itemService->update($id, $itemDTO);
        return $this->successResponse($updatedItem, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->itemService->destroy($id);
        return $this->successResponse(null, __('messages.common.deleted'));
    }
}
