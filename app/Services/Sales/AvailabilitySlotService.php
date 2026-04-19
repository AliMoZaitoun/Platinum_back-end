<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateAvailabilitySlotDTO;
use App\DTOs\Sales\Update\UpdateAvailabilitySlotDTO;
use App\Exceptions\NotFoundException;

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
