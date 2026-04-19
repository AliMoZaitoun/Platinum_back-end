<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateAppointmentDTO;
use App\DTOs\Sales\Create\UpdateAppointmentDTO;
use App\Exceptions\NotFoundException;

class AppointmentService
{
    public function __construct(
        private AppointmentDAO $appointmentDAO
    ) {}

    public function index()
    {
        $appointments = $this->appointmentDAO->index();
        if (sizeof($appointments) <= 0)
            throw new NotFoundException("Appointments");
        return $appointments;
    }

    public function store(CreateAppointmentDTO $appointmentDTO)
    {
        return $this->appointmentDAO->store($appointmentDTO);
    }

    public function show(int $id)
    {
        return $this->appointmentDAO->show($id);
    }

    public function update(int $id, UpdateAppointmentDTO $appointmentDTO)
    {
        return $this->appointmentDAO->update($id, $appointmentDTO);
    }

    public function destroy(int $id)
    {
        return $this->appointmentDAO->destroy($id);
    }
}
