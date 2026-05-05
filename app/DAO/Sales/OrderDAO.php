<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Exceptions\NotFoundException;
use App\Models\Order;

class OrderDAO
{
    public function index(array $relations = [])
    {
        $defaultRelation = ['unit', 'client', 'solution'];
        $allRelations = array_merge($defaultRelation, $relations);
        return Order::with($allRelations)->get();
    }

    public function store(CreateOrderDTO $orderDTO)
    {
        return Order::create($orderDTO->toArray());
    }

    public function show(int $id)
    {
        return Order::where('id', $id)->with(['unit', 'client', 'solution'])->get() ?? throw new NotFoundException("Order");
    }

    public function ordersByClient(int $client_id)
    {
        return Order::where('client_id', $client_id)->with(['unit', 'client', 'solution'])->get();
    }

    public function update(int $id, UpdateOrderDTO $orderDTO)
    {
        $order = $this->show($id);
        return $order->update($orderDTO->toArray());
    }

    public function destroy(int $id)
    {
        $order = $this->show($id);
        return $order->delete();
    }
}
