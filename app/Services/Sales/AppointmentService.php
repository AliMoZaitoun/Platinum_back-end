<?php

namespace App\Services\Sales;

use App\DAO\Client\ClientDAO;
use App\DAO\Sales\AppointmentDAO;
use App\DAO\Sales\AvailabilitySlotDAO;
use App\DAO\Sales\OrderDAO;
use App\DTOs\Sales\Create\CreateAppointmentDTO;
use App\DTOs\Sales\Update\UpdateAppointmentDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\V1\Order\OrderNotApprovedForAppointmentException;
use App\Exceptions\V1\Sales\CannotCancelAppointmentException;
use App\Exceptions\V1\Sales\CompleteFutureAppointmentException;
use App\Exceptions\V1\Sales\SlotNotAvailableException;
use App\Services\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentService
{
    public function __construct(
        private AppointmentDAO $dao,
        private AvailabilitySlotDAO $slotDAO,
        private Transaction $transaction,
        private OrderDAO $orderDAO,
        private ClientDAO $clientDAO
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function store(CreateAppointmentDTO $dto)
    {
        return $this->transaction->execute(function () use ($dto) {

            if ($dto->orderId) {
                $order = $this->orderDAO->show($dto->orderId);

                if ($order->status !== 'initially_accepted') {
                    throw new OrderNotApprovedForAppointmentException();
                }
            }

            $slot = $this->slotDAO->findAndLock($dto->avSlotId);

            if (! $slot || $slot->status !== 'available') {
                throw new SlotNotAvailableException();
            }

            $this->slotDAO->updateStatus($slot, 'booked');

            $appointment = $this->dao->store($dto);

            if (! empty($dto->notes)) {
                $appointment->notes()->create([
                    'text'       => $dto->notes,
                    'created_by' => $dto->createdById,
                ]);
            }

            return $appointment->load('notes');
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function myAppointments(int $client_id)
    {
        return $this->dao->showByClient($client_id);
    }

    public function update(int $id, UpdateAppointmentDTO $appointmentDTO)
    {
        return $this->dao->update($id, $appointmentDTO);
    }

    public function cancelAppointment(int $id, string $type)
    {
        return $this->transaction->execute(function () use ($id, $type) {
            $appointment = $this->dao->show($id);

            if ($type === 'client') {

                $appointmentDateTime = Carbon::parse($appointment->slot->date . ' ' . $appointment->slot->start_time);

                if (now()->diffInHours($appointmentDateTime, false) < 24) {
                    throw new CannotCancelAppointmentException();
                }
            }

            return $this->dao->cancelAppointment($id);
        });
    }

    public function markAsDone(int $id)
    {
        $appointment = $this->dao->show($id);

        $appointmentDateTime = Carbon::parse($appointment->slot->date . ' ' . $appointment->slot->start_time);

        if ($appointmentDateTime->isFuture()) {
            throw new CompleteFutureAppointmentException();
        }

        return $this->dao->markAsDone($id);
    }
}
