<?php

namespace App\Services\Sales;

use App\DAO\Sales\OrderDAO;
use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(
        private OrderDAO $orderDAO
    ) {}

    public function index()
    {
        return $this->orderDAO->index();
    }

    public function store(CreateOrderDTO $orderDTO)
    {
        $user = Auth::user();
        $orderDTO->client_id = $user->client->id;
        return $this->orderDAO->store($orderDTO);
    }

    public function show(int $id)
    {
        return $this->orderDAO->show($id);
    }

    public function ordersByClient(int $client_id)
    {
        return $this->orderDAO->ordersByClient($client_id);
    }

    public function myOrders()
    {
        $user = Auth::user();
        return $this->orderDAO->ordersByClient($user->client->id);
    }

    public function update(int $id, UpdateOrderDTO $orderDTO)
    {
        return $this->orderDAO->update($id, $orderDTO);
    }

    public function destroy(int $id)
    {
        return $this->orderDAO->destroy($id);
    }
}
