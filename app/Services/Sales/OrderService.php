<?php

namespace App\Services\Sales;

use App\DAO\Core\DepartmentDAO;
use App\DAO\RealEstate\UnitDAO;
use App\DAO\Sales\OrderDAO;
use App\DTOs\Note\Create\CreateNoteDTO;
use App\DTOs\Sales\Create\CreateOrderDTO;
use App\DTOs\Sales\Update\UpdateOrderDTO;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderStatusUpdated;
use App\Events\Order\OrderTransferred;
use App\Exceptions\V1\Order\OrderAlreadySubmittedException;
use App\Exceptions\V1\Order\UnitNotAvailableException;
use App\Services\NoteService;
use App\Services\Transaction;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(
        private OrderDAO $orderDAO,
        private DepartmentDAO $departmentDAO,
        private UnitDAO $unitDAO,
        private NoteService $noteService,
        private TransactionService $transactionService,
        private Transaction $transaction
    ) {}

    public function index(array $relations = [])
    {
        return $this->orderDAO->index($relations);
    }

    public function store(CreateOrderDTO $dto)
    {
        return $this->transaction->execute(function () use ($dto) {
            if ($dto->unit_id) {
                $isAvailable = $this->unitDAO->isUnitAvailable($dto->unit_id);

                if (! $isAvailable) {
                    throw new UnitNotAvailableException();
                }
            }

            $exists = $this->orderDAO->exists($dto->client_id, $dto->unit_id, $dto->solution_id);

            if ($exists) {
                throw new OrderAlreadySubmittedException();
            }

            $order = $this->orderDAO->store($dto);

            OrderCreated::dispatch($order);

            return $order;
        });
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

    public function getOrdersWithoutContracts()
    {
        return $this->orderDAO->getOrdersWithoutContracts();
    }

    public function getOrdersForAppointments()
    {
        return $this->orderDAO->ordersForAppointments();
    }

    public function update(int $id, UpdateOrderDTO $orderDTO, ?CreateNoteDTO $noteDTO)
    {
        return $this->transactionService->execute(function () use ($id, $orderDTO, $noteDTO) {
            $order = $this->orderDAO->update($id, $orderDTO);
            if ($noteDTO)
                $this->noteService->store($order, $noteDTO);

            if ($orderDTO->department_id) {
                OrderTransferred::dispatch($order);
            }

            if ($orderDTO->status) {
                OrderStatusUpdated::dispatch($order);
            }

            return $order;
        });
    }

    public function destroy(int $id)
    {
        return $this->orderDAO->destroy($id);
    }
}
