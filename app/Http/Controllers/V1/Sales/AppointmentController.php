<?php

namespace App\Http\Controllers\V1\Sales;

use App\DTOs\Sales\Create\CreateAppointmentDTO;
use App\DTOs\Sales\Update\UpdateAppointmentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreateAppointmentRequest;
use App\Http\Resources\V1\Sales\AppointmentResource;
use App\Services\Sales\AppointmentService;
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
        return $this->successCollection($appointments, AppointmentResource::class);
    }

    public function store(CreateAppointmentRequest $request)
    {
        $dto = CreateAppointmentDTO::fromRequest($request);
        $appointment = $this->appointmentService->store($dto);
        return $this->useResource($appointment, AppointmentResource::class, __('messages.appointment.booked'), 201);
    }

    public function show(int $id)
    {
        $appointment = $this->appointmentService->show($id);
        return $this->useResource($appointment, AppointmentResource::class);
    }

    public function myAppointments()
    {
        $client = request()->user()->client;
        $appointments = $this->appointmentService->myAppointments($client->id);
        return $this->successCollection($appointments, AppointmentResource::class);
    }

    public function update(int $id, Request $request)
    {
        $appointmentDTO = UpdateAppointmentDTO::fromRequest($request->all());
        $appointment = $this->appointmentService->update($id, $appointmentDTO);
        return $this->useResource($appointment, AppointmentResource::class, __('messages.common.updated'));
    }

    public function cancelAppointment(int $id)
    {
        $this->appointmentService->cancelAppointment($id);
        return $this->successResponse([], __('messages.appointment.cancelled'));
    }

    public function markAsDone(int $id)
    {
        $this->appointmentService->markAsDone($id);
        return $this->successResponse([], __('messages.appointment.done'));
    }
}
