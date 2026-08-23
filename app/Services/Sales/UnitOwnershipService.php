<?php

namespace App\Services\Sales;

use App\DAO\RealEstate\UnitDAO;
use App\DAO\Sales\UnitOwnershipDAO;
use App\DTOs\RealEstate\Update\UpdateUnitDTO;
use App\DTOs\Sales\Create\CreateUnitOwnershipDTO;
use App\DTOs\Sales\Update\UpdateUnitOwnershipDTO;
use App\Services\FileManagerService;
use App\Services\Transaction;

class UnitOwnershipService
{
    public function __construct(
        private UnitOwnershipDAO $dao,
        private Transaction $transaction,
        private FileManagerService $fileManager,
        private UnitDAO $unitDAO
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        return $this->dao->index($relations, $perPage);
    }

    public function store(CreateUnitOwnershipDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {

            $unitOwnership = $this->dao->store($dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $unitOwnership,
                    files: $attachments,
                    folderPath: "UnitOwnership",
                    relationName: 'attachments'
                );
            }
            return $unitOwnership;
        });
    }

    public function finalizeOwnershipForContract(int $contractId)
    {
        return $this->transaction->execute(function () use ($contractId) {
            $result = $this->dao->byContract($contractId);

            $ownerships = $result instanceof \Illuminate\Database\Eloquent\Model
                ? collect([$result])
                : collect($result);

            foreach ($ownerships as $ownership) {
                if ($ownership && $ownership->status !== 'transferred') {
                    $ownership->update([
                        'status' => 'transferred',
                        'owned_at' => now(),
                    ]);

                    $this->unitDAO->update($ownership->unit_id, UpdateUnitDTO::fromRequest(['status' => 'sold'])->toArray());
                }
            }
            return $ownerships;
        });
    }

    public function cancelOwnershipForContract(int $contractId)
    {
        return $this->transaction->execute(function () use ($contractId) {
            $result = $this->dao->byContract($contractId);

            $ownerships = $result instanceof \Illuminate\Database\Eloquent\Model
                ? collect([$result])
                : collect($result);

            foreach ($ownerships as $ownership) {
                if ($ownership) {
                    $this->unitDAO->update($ownership->unit_id, UpdateUnitDTO::fromRequest(['status' => 'available'])->toArray());
                    $ownership->delete();
                }
            }
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function clientUnits(int $client_id)
    {
        return $this->dao->clientUnits($client_id);
    }

    public function byContract(int $contractId)
    {
        return $this->dao->byContract($contractId);
    }

    public function unitClient(int $unit_id)
    {
        return $this->dao->unitClient($unit_id);
    }

    public function update(int $unit_id, UpdateUnitOwnershipDTO $dto)
    {
        return $this->dao->update($unit_id, $dto);
    }

    public function destroy(int $unit_id)
    {
        return $this->dao->destroy($unit_id);
    }
}
