<?php

namespace App\DAO\Core;

use App\DTOs\Core\CreateOfferingDTO;
use App\DTOs\Core\Update\UpdateOfferingDTO;
use App\Exceptions\NotFoundException;
use App\Models\Offering;

class OfferingDAO
{
    public function index()
    {
        return Offering::all();
    }

    public function store(CreateOfferingDTO $offeringDTO)
    {
        return Offering::create($offeringDTO->toArray());
    }

    public function show($id)
    {
        return Offering::find($id) ?? throw new NotFoundException("Offering");
    }

    public function update(int $id, UpdateOfferingDTO $offeringDTO)
    {
        $offering = $this->show($id);
        $offering->update($offeringDTO->toArray());
        return $offering;
    }

    public function destroy($id)
    {
        $offering = $this->show($id);
        return $offering->delete();
    }
}
