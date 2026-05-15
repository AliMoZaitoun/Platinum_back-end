<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\BuildingDAO;
use App\DTOs\RealEstate\Create\CreateBuildingDTO;
use App\DTOs\RealEstate\Update\UpdateBuildingDTO;
use App\Services\TranslationService;

class BuildingService
{
    public function __construct(
        private BuildingDAO $buildingDAO,
        private TranslationService $translationService
    ) {}

    public function index(array $relations = [])
    {
        return $this->buildingDAO->index($relations);
    }

    public function byProject(int $project_id, array $relations = [])
    {
        return $this->buildingDAO->byProject($project_id, $relations);
    }

    public function store(CreateBuildingDTO $dto)
    {
        $data = $dto->toArray();

        if ($dto->description) {
            $data['description'] = $this->translationService->translateAll($dto->description);
        }

        return $this->buildingDAO->store($data);
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
