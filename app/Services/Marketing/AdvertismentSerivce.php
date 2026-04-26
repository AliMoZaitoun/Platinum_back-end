<?php

namespace App\Services\Marketing;

use App\DAO\Marketing\AdvertismentDAO;
use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Exceptions\NoResultsException;

class AdvertismentSerivce
{
    public function __construct(
        private AdvertismentDAO $adDAO
    ) {}

    public function index()
    {
        $ads = $this->adDAO->index();
        if (sizeof($ads) <= 0)
            throw new NoResultsException();
        return $ads;
    }

    public function store(CreateAdDTO $dto)
    {
        return $this->adDAO->store($dto);
    }

    public function show($id)
    {
        return $this->adDAO->show($id);
    }

    public function update(int $id, UpdateAdDTO $dto)
    {
        return $this->adDAO->update($id, $dto);
    }

    public function destroy($id)
    {
        return $this->adDAO->destroy($id);
    }
}
