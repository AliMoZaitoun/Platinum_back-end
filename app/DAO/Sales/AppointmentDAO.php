<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateAppointmentDTO;
use App\DTOs\Sales\Update\UpdateAppointmentDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\Appointment;

class AppointmentDAO
{
    public function index(int $per_page = 15)
    {
        return Appointment::query()
            ->with(['order', 'client', 'slot', 'createdBy'])
            ->paginate($per_page);
    }

    public function store(CreateAppointmentDTO $dto)
    {
        return Appointment::create($dto->toArray());
    }

    public function show(int $id)
    {
        return Appointment::where('id', $id)->with(['client', 'createdBy', 'slot', 'order'])->first() ?? throw new NotFoundException("Appointment");
    }

    public function byOrder(int $orderId)
    {
        return Appointment::where('order_id', $orderId)
            ->where('status', 'done')
            ->exists();
    }

    public function showByClient(int $client_id)
    {
        return Appointment::where('client_id', $client_id)->with(['createdBy', 'slot', 'order', 'notes'])->get();
    }

    public function update(int $id, UpdateAppointmentDTO $dto)
    {
        $appointment = $this->show($id);
        return $appointment->update($dto->toArray());
    }

    public function cancelAppointment(int $id)
    {
        $app = $this->show($id);

        $app->update(['status' => 'cancelled']);

        $app->slot->update(['status' => 'available']);
    }

    public function markAsDone(int $id)
    {
        $app = $this->show($id);

        $app->update(['status' => 'done']);
    }
}
