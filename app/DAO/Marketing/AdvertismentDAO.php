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

    public function getActiveAdvertisements()
    {
        return Advertisement::active()->with('attachments')->get();
    }

    public function store(array $data)
    {
        return Advertisement::create($data);
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
