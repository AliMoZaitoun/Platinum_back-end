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

    public function store(CreateAppointmentDTO $appoinmentDTO)
    {
        return Appointment::create($appoinmentDTO->toArray());
    }

    public function show(int $id)
    {
        return Appointment::where('id', $id)->with(['client', 'createdBy', 'slot', 'order'])->get() ?? throw new NotFoundException("Appointment");
    }

    public function showByClient(int $client_id)
    {
        return Appointment::where('client_id', $client_id)->get();
    }

    public function update(int $id, UpdateAppointmentDTO $appointmentDTO)
    {
        $appointment = $this->show($id);
        return $appointment->update($appointmentDTO->toArray());
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
