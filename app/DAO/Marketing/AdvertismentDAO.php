<?php

namespace App\DAO\Marketing;

use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Exceptions\NotFoundException;
use App\Models\Advertisement;

class AdvertismentDAO
{
    public function index()
    {
        return Advertisement::all();
    }

    public function store(CreateAdDTO $adDTO)
    {
        return Advertisement::create($adDTO->toArray());
    }

    public function show($id)
    {
        return Advertisement::find($id) ?? throw new NotFoundException("Advertisement");
    }

    public function update($ad, UpdateAdDTO $adDTO)
    {
        return $ad->update($adDTO->toArray());
    }

    public function destroy($id)
    {
        $ad = $this->show($id);
        return $ad->delete();
    }
}
