<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateAvailabilitySlotDTO;
use App\DTOs\Sales\Update\UpdateAvailabilitySlotDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\AvailabilitySlot;

use function Symfony\Component\Clock\now;

class AvailabilitySlotDAO
{
    public function index()
    {
        return AvailabilitySlot::with('engineer')->get();
    }

    public function store(CreateAvailabilitySlotDTO $dto)
    {
        $data = [];
        foreach ($dto->generated_slots as $slot) {
            $data[] = [
                'employee_id' => $dto->employee_id,
                'start_time' => $slot,
                'batch_id' => $dto->batch_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        return AvailabilitySlot::insert($data);
    }

    public function show(int $id)
    {
        return AvailabilitySlot::where('id', $id)->with('engineer')->get() ?? throw new NotFoundException("Appointment");
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
