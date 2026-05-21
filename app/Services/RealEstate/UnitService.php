<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\UnitDAO;
use App\DTOs\RealEstate\Create\CreateUnitDTO;
use App\DTOs\RealEstate\Other\SearchUnitDTO;
use App\DTOs\RealEstate\Update\UpdateUnitDTO;
use App\Services\FileManagerService;
use App\Services\Transaction;
use App\Services\TranslationService;
use InvalidArgumentException;

class UnitService
{
    public function __construct(
        private UnitDAO $unitDAO,
        private TranslationService $translationService,
        private Transaction $transaction,
        private FileManagerService $fileManager
    ) {}

    # For testing just
    public function getWithoutPag()
    {
        return $this->unitDAO->getWithoutPag();
    }

    public function getUnitsForClient(int $perPage = 15)
    {
        return $this->unitDAO->getUnitsForClient($perPage);
    }

    public function getAllForAdmin(int $perPage = 15)
    {
        return $this->unitDAO->getAllForAdmin($perPage);
    }

    public function byBuilding(int $building_id, array $relations = [])
    {
        return $this->unitDAO->byBuilding($building_id, $relations);
    }

    public function store(CreateUnitDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $data = $dto->toArray();

            if ($dto->description) {
                $data['description'] = $this->translationService->translateAll($dto->description);
            }

            $unit = $this->unitDAO->store($data);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $unit,
                    files: $attachments,
                    folderPath: "units",
                    relationName: 'attachments'
                );
            }
            return $unit;
        });
    }

    public function show(int $id)
    {
        return $this->unitDAO->show($id);
    }

    public function search(SearchUnitDTO $dto)
    {
        if (isset($dto->price_min) && $dto->price_min < 0) {
            throw new InvalidArgumentException(__('messages.unit.invalid_price'));
        }

        return $this->unitDAO->search($dto->toArray());
    }

    public function update(int $id, UpdateUnitDTO $unitDTO)
    {
        return $this->unitDAO->update($id, $unitDTO);
    }

    public function destroy(int $id)
    {
        return $this->unitDAO->destroy($id);
    }
}
