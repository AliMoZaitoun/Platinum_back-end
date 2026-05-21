<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\Order;

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
        return Order::where('id', $id)->with(['unit', 'client', 'solution', 'unit.attachments', 'solution.attachments'])->first() ?? throw new NotFoundException("Order");
    }

    public function exists(int $client_id, ?int $unit_id, ?int $solution_id)
    {
        return Order::where('client_id', $client_id)
            ->when($unit_id, function ($query, $unit_id) {
                return $query->where('unit_id', $unit_id);
            })
            ->when($solution_id, function ($query, $solution_id) {
                return $query->where('solution_id', $solution_id);
            })
            ->exists();
    }

    public function getClientUnitOrders(int $client_id)
    {
        return Order::where('client_id', $client_id)
            ->whereNotNull('unit_id')
            ->with(['unit', 'unit.attachments'])->get();
    }

    public function getClientSolutionOrders(int $client_id)
    {
        return Order::where('client_id', $client_id)
            ->whereNotNull('solution_id')
            ->with(['solution', 'solution.attachments'])->get();
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
