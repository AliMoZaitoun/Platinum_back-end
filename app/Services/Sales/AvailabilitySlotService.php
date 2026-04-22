<?php

namespace App\Services\Sales;

use App\DAO\Sales\AvailabilitySlotDAO;
use App\DTOs\Sales\Create\CreateAvailabilitySlotDTO;
use App\DTOs\Sales\Update\UpdateAvailabilitySlotDTO;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AvailabilitySlotService
{
    public function __construct(
        private AvailabilitySlotDAO $avaSlotDAO
    ) {}

    public function index()
    {
        $avaSlots = $this->avaSlotDAO->index();
        if (sizeof($avaSlots) <= 0)
            throw new NotFoundException("AvailableSlot");
        return $avaSlots;
    }

    public function store(CreateAvailabilitySlotDTO $avSlotDTO)
    {
        $user = Auth::user();
        $batch_id = (string) Str::uuid();

        $current_time = strtotime($avSlotDTO->start_time);
        $end_time = strtotime($avSlotDTO->end_time);
        $interval = 1200;

        $slots = [];
        while ($current_time + $interval <= $end_time) {
            $slots[] = date('H:i:s', $current_time);
            $current_time += $interval;
        }
        // return $slots;

        $avSlotDTO->employee_id = $user->employee->id;
        $avSlotDTO->batch_id = $batch_id;
        $avSlotDTO->generated_slots = $slots;
        return $this->avaSlotDAO->store($avSlotDTO);
    }

    public function show(int $id)
    {
        return $this->avaSlotDAO->show($id);
    }

    public function update(int $id, UpdateAvailabilitySlotDTO $avSlotDTO)
    {
        return $this->avaSlotDAO->update($id, $avSlotDTO);
    }

    public function destroy(int $id)
    {
        return $this->avaSlotDAO->destroy($id);
    }
}
