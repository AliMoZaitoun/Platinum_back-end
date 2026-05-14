<?php

namespace App\Http\Controllers\V1\Core;

use App\DTOs\Core\Create\CreateItemDTO;
use App\DTOs\Core\Update\UpdateItemDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\CreateItemRequest;
use App\Http\Resources\V1\Core\ItemResource;
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
        return $this->successCollection($items, ItemResource::class);
    }

    public function store(CreateItemRequest $addItemRequest)
    {
        $itemDTO = CreateItemDTO::fromRequest($addItemRequest->validated());

        $item = $this->itemService->store($itemDTO);
        return $this->useResource($item, ItemResource::class, __('messages.common.stored'), 201);
    }

    public function getItemsByWarehouseID(int $warehouse_id)
    {
        $items = $this->itemService->getItemsByWarehouseID($warehouse_id);
        return $this->successCollection($items, ItemResource::class);
    }

    public function show(int $id)
    {
        $item = $this->itemService->show($id);
        return $this->useResource($item, ItemResource::class);
    }

    public function update(int $id, Request $request)
    {
        $itemDTO = UpdateItemDTO::fromRequest($request->all());

        $updatedItem = $this->itemService->update($id, $itemDTO);
        return $this->useResource($updatedItem, ItemResource::class, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->itemService->destroy($id);
        return $this->successResponse(null, __('messages.common.deleted'));
    }
}
