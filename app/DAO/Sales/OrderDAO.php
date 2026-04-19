<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Exceptions\NotFoundException;
use App\Models\Order;

class OrderDAO
{
    public function index()
    {
        return Order::all();
    }

    public function store(CreateOrderDTO $orderDTO)
    {
        return Order::create($orderDTO->toArray());
    }

    public function show(int $id)
    {
        return Order::find($id) ?? throw new NotFoundException("Order");
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
