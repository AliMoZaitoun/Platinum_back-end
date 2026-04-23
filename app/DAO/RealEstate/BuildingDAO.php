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
        return Building::where('project_id', $project_id)->get();
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
        $building->update($buildingDTO->toArray());
        return $building;
    }

    public function destroy($id)
    {
        $building = $this->show($id);
        return $building->delete();
    }
}
