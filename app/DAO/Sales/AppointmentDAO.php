<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateAppointmentDTO;
use App\DTOs\Sales\Create\UpdateAppointmentDTO;
use App\Exceptions\NotFoundException;
use App\Models\Appointment;

class AppointmentDAO
{
    public function index()
    {
        return Appointment::all();
    }

    public function store(CreateAppointmentDTO $appoinmentDTO)
    {
        return Appointment::create($appoinmentDTO->toArray());
    }

    public function show(int $id)
    {
        return Appointment::find($id) ?? throw new NotFoundException("Appointment");
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

    public function destroy(int $id)
    {
        $appointment = $this->show($id);
        return $appointment->delete();
    }
}
