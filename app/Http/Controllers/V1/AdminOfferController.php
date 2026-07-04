<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Marketing\Create\CreateOfferDTO;
use App\DTOs\Marketing\Update\UpdateOfferDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Marketing\CreateOfferRequest;
use App\Http\Requests\V1\Marketing\UpdateOfferRequest;
use App\Http\Resources\V1\Marketing\AdminOfferResource;
use App\Http\Resources\V1\Marketing\ClientOfferResource;
use App\Services\Marketing\OfferSerivce;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOfferController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private OfferSerivce $service
    ) {}

    public function index()
    {
        $offers = $this->service->index();
        return $this->successCollection($offers, AdminOfferResource::class);
    }

    public function activeOffers()
    {
        $offers = $this->service->getActiveOffers();
        return $this->successCollection($offers, AdminOfferResource::class);
    }

    public function show(int $id)
    {
        $offer = $this->service->show($id);
        return $this->useResource($offer, AdminOfferResource::class);
    }

    public function store(CreateOfferRequest $request)
    {
        $dto = CreateOfferDTO::fromRequest($request->validated(), Auth::user()->employee->id);
        $offer = $this->service->store($dto);
        return $this->useResource($offer, AdminOfferResource::class, __('messages.common.created'), 201);
    }

    public function update(int $id, UpdateOfferRequest $request)
    {
        $dto = UpdateOfferDTO::fromRequest($request->toArray());
        $offer = $this->service->update($id, $dto);
        return $this->useResource($offer, AdminOfferResource::class, __('messages.common.updated'), 201);
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
