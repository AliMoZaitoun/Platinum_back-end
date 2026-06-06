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

    public function clientComplaints(int $client_id)
    {
        return Complaint::where('client_id', $client_id)
            ->with(['type', 'attachments'])
            ->get();
    }

    public function show(int $id)
    {
        return Complaint::where('id', $id)->first() ?? throw new NotFoundException("Complaint");
    }

    public function update(int $id, UpdateComplaintDTO $dto)
    {
        $comp = $this->show($id);
        $comp->update($dto->toArray());
        return $comp;
    }

    public function destroy(int $id)
    {
        $comp = $this->show($id);
        return $comp->delete();
    }
}
