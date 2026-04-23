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
