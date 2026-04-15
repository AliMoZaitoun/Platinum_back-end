<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Basics\CreateOfferingDTO;
use App\DTOs\Basics\Update\UpdateOfferingDTO;
use App\Http\Controllers\Controller;
use App\Services\OfferingService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private OfferingService $offeringService
    ) {}

    public function createOffering(Request $request)
    {
        $offeringDTO = new CreateOfferingDTO(
            id: null,
            name: $request->input('name'),
            description: $request->input('description'),
            price: $request->input('price')
        );

        $offering = $this->offeringService->createOffering($offeringDTO);
        return $this->successResponse($offering, "Offering created successfully.");
    }

    public function getAllOfferings()
    {
        $offerings = $this->offeringService->getAllOfferings();
        return $this->successResponse($offerings, "Offerings retrieved successfully.");
    }

    public function getOfferingByID($offering_id)
    {
        $offering = $this->offeringService->getOfferingById($offering_id);
        return $this->successResponse($offering, "Offering retrieved successfully.");
    }

    public function updateOffering($offering_id, Request $request)
    {
        $offeringDTO = new UpdateOfferingDTO(
            id: $offering_id,
            name: $request->input('name'),
            description: $request->input('description')
        );

        $offering = $this->offeringService->updateOffering($offering_id, $offeringDTO);
        return $this->successResponse($offering, "Offering updated successfully.");
    }

    public function deleteOffering($offering_id)
    {
        $this->offeringService->deleteOffering($offering_id);
        return $this->successResponse(null, "Offering removed successfully.");
    }
}
