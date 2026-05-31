<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateComplaintDTO;
use App\DTOs\Sales\Update\UpdateComplaintDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\Complaint;

class ComplaintDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['client', 'unit', 'type'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Complaint::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function store(CreateComplaintDTO $dto)
    {
        return Complaint::create($dto->toArray());
    }

    public function show(int $unit_id)
    {
        return Complaint::where('unit_id', $unit_id)->first() ?? throw new NotFoundException("Complaint");
    }

    public function clientUnits(int $client_id)
    {
        return Complaint::where('client_id', $client_id)
            ->with(['unit', 'attachments'])
            ->get();
    }

    public function unitClient(int $unit_id)
    {
        return Complaint::where('unit_id', $unit_id)
            ->with(['unit', 'attachments'])
            ->get();
    }

    public function update(int $id, UpdateComplaintDTO $dto)
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
