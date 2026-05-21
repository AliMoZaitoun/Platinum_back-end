<?php

namespace App\Http\Controllers\V1\Sales;

use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreateOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Http\Resources\V1\Sales\ClientOrderResource;
use App\Services\Sales\OrderService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index()
    {
        $orders = $this->orderService->index();
        return $this->successCollection($orders, OrderResource::class);
    }

    public function store(CreateOrderRequest $request)
    {
        $orderDTO = CreateOrderDTO::fromRequest(
            $request->validated(),
            $request->user()->client->id
        );

        $order = $this->orderService->store($orderDTO);
        return $this->useResource($order, ClientOrderResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $order = $this->orderService->show($id);
        return $this->useResource($order, OrderResource::class);
    }

    public function getClientUnitOrders(int $client_id)
    {
        $orders = $this->orderService->getClientUnitOrders($client_id);
        return $this->successCollection($orders, OrderResource::class);
    }

    public function getClientResourcOrders(int $client_id)
    {
        $orders = $this->orderService->getClientUnitOrders($client_id);
        return $this->successCollection($orders, OrderResource::class);
    }

    public function myUnitOrders()
    {
        $clientId = Auth::user()->client->id;
        $orders = $this->orderService->getClientUnitOrders($clientId);
        return $this->successCollection($orders, ClientOrderResource::class);
    }

    public function mySolutionOrders()
    {
        $clientId = Auth::user()->client->id;
        $orders = $this->orderService->getClientSolutionOrders($clientId);
        return $this->successCollection($orders, ClientOrderResource::class);
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
