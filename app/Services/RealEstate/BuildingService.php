<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\BuildingDAO;
use App\DTOs\RealEstate\Create\CreateBuildingDTO;
use App\DTOs\RealEstate\Update\UpdateBuildingDTO;

class BuildingService
{
    public function __construct(
        private BuildingDAO $buildingDAO
    ) {}

    public function index(int $project_id)
    {
        return $this->buildingDAO->index($project_id);
    }

    public function store(CreateBuildingDTO $buildingDTO)
    {
        return $this->buildingDAO->store($buildingDTO);
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
