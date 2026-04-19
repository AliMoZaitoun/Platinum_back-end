<?php

namespace App\Http\Controllers\V1\Core;

use App\DTOs\Core\CreateOfferingDTO;
use App\DTOs\Core\Update\UpdateOfferingDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateOfferingRequest;
use App\Services\Core\OfferingService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private OfferingService $offeringService
    ) {}


    public function index()
    {
        $offerings = $this->offeringService->index();
        return $this->successResponse($offerings, "Offerings retrieved successfully.");
    }

    public function store(CreateOfferingRequest $request)
    {
        $offeringDTO = CreateOfferingDTO::fromRequest($request->validated());

        $offering = $this->offeringService->store($offeringDTO);
        return $this->successResponse($offering, __('messages.common.stored'), 201);
    }

    public function show($id)
    {
        $offering = $this->offeringService->show($id);
        return $this->successResponse($offering, "Offering retrieved successfully.");
    }

    public function update($id, Request $request)
    {
        $offeringDTO = UpdateOfferingDTO::fromRequest($request->all());

        $offering = $this->offeringService->update($id, $offeringDTO);
        return $this->successResponse($offering, __('messages.common.updated'));
    }

    public function destroy($id)
    {
        $this->offeringService->destroy($id);
        return $this->successResponse(null, __('messages.common.deleted'));
    }
}
