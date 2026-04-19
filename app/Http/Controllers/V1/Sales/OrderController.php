<?php

namespace App\Http\Controllers\V1\Sales;

use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreateOrderRequest;
use App\Services\Sales\OrderService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index()
    {
        $orders = $this->orderService->index();
        return $this->successResponse($orders);
    }

    public function store(CreateOrderRequest $request)
    {
        $orderDTO = CreateOrderDTO::fromRequest($request->validated());
        $order = $this->orderService->store($orderDTO);
        return $this->successResponse($order, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $order = $this->orderService->show($id);
        return $this->successResponse($order);
    }

    public function update(int $id, Request $request)
    {
        $orderDTO = UpdateOrderDTO::fromRequest($request->all());
        $order = $this->orderService->update($id, $orderDTO);
        return $this->successResponse($order, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->orderService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
