<?php

namespace App\Services\Sales;

use App\DAO\Sales\OrderDAO;
use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Exceptions\V1\Order\OrderAlreadySubmittedException;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(
        private OrderDAO $orderDAO
    ) {}

    public function index(array $relations = [])
    {
        return $this->orderDAO->index($relations);
    }

    public function store(CreateOrderDTO $dto)
    {
        $exists = $this->orderDAO->exists($dto->client_id, $dto->unit_id, $dto->solution_id);

        if ($exists) {
            throw new OrderAlreadySubmittedException();
        }

        return $this->orderDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->orderDAO->show($id);
    }

    public function getClientUnitOrders(int $client_id)
    {
        return $this->orderDAO->getClientUnitOrders($client_id);
    }

    public function getClientSolutionOrders(int $client_id)
    {
        return $this->orderDAO->getClientSolutionOrders($client_id);
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
