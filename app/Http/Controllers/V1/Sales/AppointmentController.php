<?php

namespace App\Http\Controllers\V1\Sales;

use App\DAO\Sales\AppointmentService;
use App\DTOs\Sales\Create\CreateAppointmentDTO;
use App\DTOs\Sales\Create\UpdateAppointmentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreateAppointmentRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private AppointmentService $appointmentService
    ) {}

    public function index()
    {
        $appointments = $this->appointmentService->index();
        return $this->successResponse($appointments);
    }

    public function store(CreateAppointmentRequest $request)
    {
        $appointmentDTO = CreateAppointmentDTO::fromRequest($request->validated());
        $appointment = $this->appointmentService->store($appointmentDTO);
        return $this->successResponse($appointment, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $appointment = $this->appointmentService->show($id);
        return $this->successResponse($appointment);
    }

    public function myAppointments()
    {
        $appointments = $this->appointmentService->myAppointments();
        return $this->successResponse($appointments);
    }

    public function update(int $id, Request $request)
    {
        $appointmentDTO = UpdateAppointmentDTO::fromRequest($request->all());
        $appointment = $this->appointmentService->update($id, $appointmentDTO);
        return $this->successResponse($appointment, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->appointmentService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
