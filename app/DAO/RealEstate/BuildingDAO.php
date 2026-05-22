<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateBuildingDTO;
use App\DTOs\RealEstate\Update\UpdateBuildingDTO;
use App\Exceptions\NotFoundException;
use App\Models\RealEstate\Building;

class BuildingDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelation = ['project', 'attachments'];
        $allRelations = array_merge($defaultRelation, $relations);

        return Building::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function byProject(int $project_id, array $relations = [], int $perPage = 15)
    {
        $defaultRelation = ['project'];
        $allRelations = array_merge($defaultRelation, $relations);

        return Building::query()
            ->with($allRelations)
            ->where('project_id', $project_id)
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data)
    {
        return Building::create($data);
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

    public function destroy(int $id)
    {
        $building = $this->show($id);
        return $building->delete();
    }
}
