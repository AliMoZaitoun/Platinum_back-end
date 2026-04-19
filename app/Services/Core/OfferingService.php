<?php

namespace App\Services\Core;

use App\DAO\Core\OfferingDAO;
use App\DTOs\Core\CreateOfferingDTO;
use App\DTOs\Core\Update\UpdateOfferingDTO;

class OfferingService
{
    public function __construct(
        private OfferingDAO $offeringDAO
    ) {}

    public function store(CreateOfferingDTO $offeringDTO)
    {
        return $this->offeringDAO->store($offeringDTO);
    }

    public function index()
    {
        return $this->offeringDAO->index();
    }

    public function show(int $id)
    {
        return $this->offeringDAO->show($id);
    }

    public function update(int $id, UpdateOfferingDTO $offeringDTO)
    {
        return $this->offeringDAO->update($id, $offeringDTO);
    }

    public function destroy($id)
    {
        return $this->offeringDAO->destroy($id);
    }
}
