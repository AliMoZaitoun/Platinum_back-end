<?php

namespace App\DAO\Basics;

use App\DTOs\Basics\CreateOfferingDTO;
use App\DTOs\Basics\Update\UpdateOfferingDTO;
use App\Exceptions\NotFoundException;
use App\Models\Offering;

class OfferingDAO
{
    public function createOffering(CreateOfferingDTO $offeringDTO)
    {
        return Offering::create($offeringDTO->toArray());
    }

    public function getAllOfferings()
    {
        return Offering::all();
    }

    public function getOfferingById($id)
    {
        return Offering::find($id);
    }

    public function updateOffering($offering, UpdateOfferingDTO $offeringDTO)
    {
        return $offering->update(array_filter($offeringDTO->toArray(), fn($v) => !is_null($v)));
    }

    public function deleteOffering($offering)
    {
        return $offering->delete();
    }
}
