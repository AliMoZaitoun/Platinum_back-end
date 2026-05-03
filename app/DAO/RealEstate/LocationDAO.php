<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateLocationDTO;
use App\DTOs\RealEstate\Update\UpdateLocationDTO;
use App\Exceptions\NotFoundException;
use App\Models\Location;

class LocationDAO
{
    public function index(array $relations = [])
    {
        $defaultRelations = ['parent'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Location::with($allRelations)->get();
    }

    public function store(CreateLocationDTO $dto)
    {
        return Location::create($dto->toArray());
    }

    public function show(int $id)
    {
        return Location::find($id) ?? throw new NotFoundException("Location");
    }

    public function update(int $id, UpdateLocationDTO $dto)
    {
        $location = $this->show($id);
        $location->update($dto->toArray());
        return $location;
    }

    public function destroy($id)
    {
        $location = $this->show($id);
        return $location->delete();
    }
}
