<?php

namespace App\DAO\Finance;

use App\DTOs\Legal\Create\CreateContractExceptionDTO;
use App\DTOs\Finance\Create\ReviewContractExceptionDTO;
use App\Exceptions\NotFoundException;
use App\Models\Finance\ContractException;

class ContractExceptionDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['contract.client', 'requester'];
        $allRelations = array_merge($defaultRelations, $relations);

        return ContractException::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function store(CreateContractExceptionDTO $dto, int $contractId, int $requestedBy)
    {
        return ContractException::create($dto->toArray($contractId, $requestedBy));
    }

    public function show(int $id, $relations = [])
    {
        return ContractException::where('id', $id)
            ->with($relations)
            ->first() ?? throw new NotFoundException("ContractException");
    }

    public function review(int $id, ReviewContractExceptionDTO $dto)
    {
        $exception = $this->show($id);
        $exception->update($dto->toArray());
        return $exception->refresh();
    }

    public function getPendingExceptions(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['contract.client', 'requester'];
        $allRelations = array_merge($defaultRelations, $relations);

        return ContractException::query()
            ->with($allRelations)
            ->where('status', 'pending')
            ->latest()
            ->paginate($perPage);
    }
}
