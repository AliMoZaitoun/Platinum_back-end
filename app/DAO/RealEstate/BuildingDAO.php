<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateBuildingDTO;
use App\DTOs\RealEstate\Update\UpdateBuildingDTO;
use App\Exceptions\NotFoundException;
use App\Models\Building;

class BuildingDAO
{
    public function index(int $project_id)
    {
        return Building::where('project_id', $project_id);
    }

    public function store(CreateBuildingDTO $buildingDTO)
    {
        return Building::create($buildingDTO->toArray());
    }

    public function show(int $id)
    {
        return Building::find($id) ?? throw new NotFoundException("Building");
    }

    public function update(int $id, UpdateBuildingDTO $buildingDTO)
    {
        $building = $this->show($id);
        return $building->update($buildingDTO->toArray());
    }

    public function destroy($id)
    {
        $building = $this->show($id);
        return $building->delete();
    }
}
