<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\LocationDAO;
use App\DTOs\RealEstate\Create\CreateLocationDTO;
use App\DTOs\RealEstate\Update\UpdateLocationDTO;

class LocationService
{
    public function __construct(
        private LocationDAO $locationDAO
    ) {}

    public function index()
    {
        return $this->locationDAO->index();
    }

    public function store(CreateLocationDTO $dto)
    {
        return $this->locationDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->locationDAO->show($id);
    }

    public function update(int $id, UpdateLocationDTO $dto)
    {
        return $this->locationDAO->update($id, $dto);
    }

    public function destroy($id)
    {
        return $this->locationDAO->destroy($id);
    }
}
