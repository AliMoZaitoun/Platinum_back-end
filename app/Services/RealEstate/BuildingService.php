<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\BuildingDAO;
use App\DTOs\RealEstate\Create\CreateBuildingDTO;
use App\DTOs\RealEstate\Update\UpdateBuildingDTO;
use App\Services\FileManagerService;
use App\Services\Transaction;
use App\Services\TranslationService;

class BuildingService
{
    public function __construct(
        private BuildingDAO $buildingDAO,
        private TranslationService $translationService,
        private Transaction $transaction,
        private FileManagerService $fileManager
    ) {}

    public function index(array $relations = [])
    {
        return $this->buildingDAO->index($relations);
    }

    public function byProject(int $project_id, array $relations = [])
    {
        return $this->buildingDAO->byProject($project_id, $relations);
    }

    public function store(CreateBuildingDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $data = $dto->toArray();

            if ($dto->description) {
                $data['description'] = $this->translationService->translateAll($dto->description);
            }

            $building = $this->buildingDAO->store($data);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $building,
                    files: $attachments,
                    folderPath: "buildings",
                    relationName: 'attachments'
                );
            }
            return $building;
        });
    }

    public function show(int $id)
    {
        return $this->buildingDAO->show($id);
    }

    public function update(int $id, UpdateBuildingDTO $buildingDTO)
    {
        return $this->buildingDAO->update($id, $buildingDTO);
    }

    public function destroy($id)
    {
        return $this->buildingDAO->destroy($id);
    }
}
