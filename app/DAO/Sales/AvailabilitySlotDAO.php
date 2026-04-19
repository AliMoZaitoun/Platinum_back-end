<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateAvailabilitySlotDTO;
use App\DTOs\Sales\Update\UpdateAvailabilitySlotDTO;
use App\Exceptions\NotFoundException;
use App\Models\Availability_slot;

class AvailabilitySlotDAO
{
    public function index()
    {
        return Availability_slot::all();
    }

    public function store(CreateAvailabilitySlotDTO $appoinmentDTO)
    {
        return Availability_slot::create($appoinmentDTO->toArray());
    }

    public function show(int $id)
    {
        return Availability_slot::find($id) ?? throw new NotFoundException("Appointment");
    }

    public function update(int $id, UpdateAvailabilitySlotDTO $appointmentDTO)
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
