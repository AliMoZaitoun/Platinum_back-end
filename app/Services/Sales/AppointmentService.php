<?php

namespace App\Services\Sales;

use App\DAO\Sales\AppointmentDAO;
use App\DTOs\Sales\Create\CreateAppointmentDTO;
use App\DTOs\Sales\Update\UpdateAppointmentDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\V1\Sales\CompleteFutureAppointmentException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentService
{
    public function __construct(
        private AppointmentDAO $dao
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function store(CreateAppointmentDTO $appointmentDTO)
    {
        return $this->dao->store($appointmentDTO);
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

    public function cancelAppointment(int $id)
    {
        return $this->dao->cancelAppointment($id);
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
