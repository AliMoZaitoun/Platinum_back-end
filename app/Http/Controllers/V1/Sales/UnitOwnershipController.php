<?php

namespace App\Http\Controllers\V1\Sales;


use App\DTOs\Sales\Create\CreateUnitOwnershipDTO;
use App\DTOs\Sales\Update\UpdateUnitOwnershipDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\SaleUnitRequest;
use App\Http\Resources\V1\Sales\ClientUnitOwnershipResource;
use App\Http\Resources\V1\Sales\UnitOwnershipResource;
use App\Services\Sales\UnitOwnershipService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UnitOwnershipController extends Controller
{
    use ResponseTrait;
    public function __construct(private UnitOwnershipService $service) {}

    public function index()
    {
        $units = $this->service->index();
        return $this->successCollection($units, UnitOwnershipResource::class);
    }

    public function store(int $unit_id, SaleUnitRequest $request)
    {
        $dto = CreateUnitOwnershipDTO::fromRequest($unit_id, $request->validated());

        $this->service->store($dto, $request->file('attachments'));

        return $this->successResponse([], __('messages.common.stored'), 201);
    }

    public function update(int $unit_id, Request $request)
    {
        $dto = UpdateUnitOwnershipDTO::fromRequest($unit_id, $request->all());

        $this->service->update($unit_id, $dto);

        return $this->successResponse([], __('messages.common.updated'), 200);
    }

    public function destroy(int $unit_id)
    {
        $this->service->destroy($unit_id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }

    public function clientUnits(int $client_id)
    {
        $units = $this->service->clientUnits($client_id);
        return $this->successCollection($units, UnitOwnershipResource::class);
    }

    public function myUnits()
    {
        $client = request()->user()->client;

        $units = $this->service->clientUnits($client->id);
        return $this->successCollection($units, ClientUnitOwnershipResource::class);
    }

    public function unitClient(int $unit_id)
    {
        $clients = $this->service->unitClient($unit_id);
        return $this->successCollection($clients, null);
    }
}
