<?php

namespace App\Services;

use App\DAO\Basics\OfferingDAO;
use App\DTOs\Basics\CreateOfferingDTO;
use App\DTOs\Basics\Update\UpdateOfferingDTO;
use App\Exceptions\NotFoundException;

class OfferingService
{
    public function __construct(
        private OfferingDAO $offeringDAO
    ) {}

    public function createOffering(CreateOfferingDTO $offeringDTO)
    {
        return $this->offeringDAO->createOffering($offeringDTO);
    }

    public function getAllOfferings()
    {
        return $this->offeringDAO->getAllOfferings();
    }

    private function findOrFail($offeringID)
    {
        return $this->offeringDAO->getOfferingById($offeringID) ?? throw new NotFoundException('Offering');
    }

    public function getOfferingById($offeringID)
    {
        return $this->findOrFail($offeringID);
    }

    public function updateOffering($offeringID, UpdateOfferingDTO $offeringDTO)
    {
        $offering = $this->getOfferingById($offeringID);
        return $this->offeringDAO->updateOffering($offering, $offeringDTO);
    }

    public function deleteOffering($offeringID)
    {
        $offer = $this->getOfferingById($offeringID);
        return $this->offeringDAO->deleteOffering($offer);
    }
}
