<?php

namespace App\DAO\Marketing;

use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Exceptions\NotFoundException;
use App\Models\Marketing\Advertisement;

class AdvertismentDAO
{
    public function index()
    {
        return Advertisement::latest()->get();
    }

    public function byStatus(int $status)
    {
        return Advertisement::where('status', $status)->get();
    }

    public function store(CreateAdDTO $adDTO)
    {
        return Advertisement::create($adDTO->toArray());
    }

    public function show(int $id)
    {
        return Advertisement::find($id) ?? throw new NotFoundException("Advertisement");
    }

    public function update(int $id, UpdateAdDTO $adDTO)
    {
        $ad = $this->show($id);
        return $ad->update($adDTO->toArray());
    }

    public function destroy(int $id)
    {
        $ad = $this->show($id);
        return $ad->delete();
    }
}
