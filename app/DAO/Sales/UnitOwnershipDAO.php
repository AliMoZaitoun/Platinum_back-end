<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateUnitOwnershipDTO;
use App\DTOs\Sales\Update\UpdateUnitOwnershipDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\UnitOwnership;

class UnitOwnershipDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['client', 'unit'];
        $allRelations = array_merge($defaultRelations, $relations);
        return UnitOwnership::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function store(CreateUnitOwnershipDTO $dto)
    {
        return UnitOwnership::create($dto->toArray());
    }

    public function show(int $unit_id)
    {
        return UnitOwnership::where('unit_id', $unit_id)->first() ?? throw new NotFoundException("UnitOwnership");
    }

    public function clientUnits(int $client_id)
    {
        return UnitOwnership::where('client_id', $client_id)
            ->with(['unit', 'attachments'])
            ->get();
    }

    public function unitClient(int $unit_id)
    {
        return UnitOwnership::where('unit_id', $unit_id)
            ->with(['unit', 'attachments'])
            ->get();
    }

    public function update(int $id, UpdateUnitOwnershipDTO $dto)
    {
        $unitOs = $this->show($id);
        return $unitOs->update($dto->toArray());
    }

    public function destroy(int $unit_id)
    {
        $unitOs = $this->show($unit_id);
        return $unitOs->delete();
    }
}
