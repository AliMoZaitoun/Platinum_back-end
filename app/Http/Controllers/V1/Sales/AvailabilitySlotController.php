<?php

namespace App\Http\Controllers\V1\Sales;

use App\Services\Sales\AvailabilitySlotService;
use App\DTOs\Sales\Create\CreateAvailabilitySlotDTO;
use App\DTOs\Sales\Update\UpdateAvailabilitySlotDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreateAvailableSlotRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AvailabilitySlotController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private AvailabilitySlotService $avaSlotService
    ) {}

    public function index()
    {
        $avaSlots = $this->avaSlotService->index();
        return $this->successResponse($avaSlots);
    }

    public function store(CreateAvailableSlotRequest $request)
    {
        $avaSlotDTO = CreateAvailabilitySlotDTO::fromRequest($request->validated());
        $avaSlot = $this->avaSlotService->store($avaSlotDTO);
        return $this->successResponse($avaSlot, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $avaSlot = $this->avaSlotService->show($id);
        return $this->successResponse($avaSlot);
    }

    public function update(int $id, Request $request)
    {
        $avaSlotDTO = UpdateAvailabilitySlotDTO::fromRequest($request->all());
        $avaSlot = $this->avaSlotService->update($id, $avaSlotDTO);
        return $this->successResponse($avaSlot, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->avaSlotService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
