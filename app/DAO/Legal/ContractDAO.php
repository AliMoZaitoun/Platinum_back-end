<?php

namespace App\DAO\Legal;

use App\DTOs\Legal\Create\CreateContractDTO;
use App\DTOs\Legal\Update\UpdateContractDTO;
use App\Exceptions\NotFoundException;
use App\Models\Legal\Contract;

class ContractDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['client', 'attachments', 'latestException'];
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

    public function storeArray(array $data)
    {
        return Contract::create($data);
    }

    public function show(int $id)
    {
        return Contract::where('id', $id)
            ->with([
                'order',
                'client',
                'employee',
                'attachments',
                'latestException',
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

    public function updateStatus(int $id, string $status)
    {
        $contract = $this->show($id);
        $contract->update(['status' => $status]);
        return $contract->refresh();
    }

    public function destroy(int $id)
    {
        $contract = $this->show($id);
        return $contract->delete();
    }

    public function getPendingApprovalContracts(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['client', 'employee', 'latestException'];
        $allRelations = array_merge($defaultRelations, $relations);

        return Contract::query()
            ->with($allRelations)
            ->where('status', 'pending_approval')
            ->latest()
            ->paginate($perPage);
    }
}
