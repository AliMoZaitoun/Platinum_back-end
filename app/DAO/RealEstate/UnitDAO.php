<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateUnitDTO;
use App\DTOs\RealEstate\Update\UpdateUnitDTO;
use App\Exceptions\NotFoundException;
use App\Models\Unit;

class UnitDAO
{
    public function index(int $building_id)
    {
        return Unit::where('building_id', $building_id)->get();
    }

    public function store(CreateUnitDTO $UnitDTO)
    {
        return Unit::create($UnitDTO->toArray());
    }

    public function show(int $id)
    {
        return Unit::find($id) ?? throw new NotFoundException("Unit");
    }

    protected function getBaseSearchQuery()
    {
        return Unit::query()
            ->select('units.*')
            ->join('buildings', 'units.building_id', '=', 'buildings.id')
            ->join('projects', 'buildings.project_id', '=', 'projects.id');
    }

    public function search(array $filters)
    {
        $query = $this->getBaseSearchQuery();

        if (!empty($filters['location_id'])) {
            $query->where('projects.location_id', $filters['location_id']);
        }

        if (!empty($filters['price_min'])) {
            $query->where('units.price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('units.price', '<=', $filters['price_max']);
        }

        if (!empty($filters['rooms_count'])) {
            $query->where('units.rooms_count', $filters['rooms_count']);
        }

        if (!empty($filters['type'])) {
            $query->where('units.type', $filters['type']);
        }

        return $query->with(['building.project.location'])
            ->paginate(12);
    }

    public function update(int $id, UpdateUnitDTO $UnitDTO)
    {
        $unit = $this->show($id);
        $unit->update($UnitDTO->toArray());
        return $unit;
    }

    public function destroy($id)
    {
        $unit = $this->show($id);
        return $unit->delete();
    }
}
