<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateContractDTO;
use App\DTOs\Sales\UPdate\UpdateContractDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\Contract;

class ContractDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['client', 'attachments'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Contract::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function store(CreateContractDTO $dto)
    {
        return Contract::create($dto->toArray());
    }

    public function show(int $id)
    {
        return Contract::where('id', $id)
            ->with([
                'order',
                'client',
                'employee',
                'attachments',
                'payments' => function ($query) {
                    $query->orderBy('payment_date', 'asc');
                }
            ])
            ->first() ?? throw new NotFoundException("Contract");
    }

    public function byClient(int $client_id)
    {
        return Contract::where('client_id', $client_id)
            ->with([
                'order',
                'client',
                'attachments',
                'payments' => function ($query) {
                    $query->orderBy('payment_date', 'asc');
                }
            ])
            ->get();
    }

    public function changeStatus(int $id, UpdateContractDTO $dto)
    {
        $contract = $this->show($id);
        $contract->update($dto->toArray());
        return $contract->refresh();
    }

    public function destroy(int $id)
    {
        $contract = $this->show($id);
        return $contract->delete();
    }
}
