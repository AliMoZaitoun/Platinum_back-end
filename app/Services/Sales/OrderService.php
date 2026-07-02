<?php

namespace App\Services\Sales;

use App\DAO\Core\DepartmentDAO;
use App\DAO\Sales\OrderDAO;
use App\DTOs\Note\Create\CreateNoteDTO;
use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Exceptions\V1\Order\OrderAlreadySubmittedException;
use App\Services\NoteService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(
        private OrderDAO $orderDAO,
        private DepartmentDAO $departmentDAO,
        private NoteService $noteService,
        private TransactionService $transactionService
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

        if ($dto->unit_id) {
            $dto->department_id = 5;
        } else if ($dto->solution_id) {
            $dto->department_id = 1;
        }

        return $this->orderDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->orderDAO->show($id);
    }

    public function clientUnitOrders(int $client_id)
    {
        return $this->orderDAO->clientUnitOrders($client_id);
    }

    public function clientSolutionOrders(int $client_id)
    {
        return $this->orderDAO->clientSolutionOrders($client_id);
    }

    public function departmentOrders(int $department_id)
    {
        return $this->orderDAO->departmentOrders($department_id);
    }

    public function update(int $id, UpdateOrderDTO $orderDTO, CreateNoteDTO $noteDTO = null)
    {
        return $this->transactionService->execute(function () use ($id, $orderDTO, $noteDTO) {
            $order = $this->orderDAO->update($id, $orderDTO);
            if ($noteDTO)
                $this->noteService->store($order, $noteDTO);
            return $order;
        });
    }

    public function destroy(int $id)
    {
        return $this->orderDAO->destroy($id);
    }
}
