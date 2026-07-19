<?php

namespace App\DAO\Marketing;

use App\DTOs\Marketing\Create\CreateOfferDTO;
use App\DTOs\Marketing\Update\UpdateOfferDTO;
use App\Exceptions\NotFoundException;
use App\Models\Marketing\Offer;

class OfferDAO
{

    public function index()
    {
        return Offer::latest()->get();
    }

    public function getActiveOffers()
    {
        return Offer::where('status', true)->get();
    }

    public function store(CreateOfferDTO $dto)
    {
        return Offer::create($dto->toArray());
    }

    public function show(int $id)
    {
        return Offer::find($id) ?? throw new NotFoundException("Offer");
    }

    public function update(int $id, UpdateOfferDTO $dto)
    {
        $ad = $this->show($id);
        return $ad->update($dto->toArray());
    }

    public function destroy(int $id)
    {
        $ad = $this->show($id);
        return $ad->delete();
    }
}
