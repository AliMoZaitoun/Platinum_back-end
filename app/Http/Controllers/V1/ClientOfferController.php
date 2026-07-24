<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Marketing\AdminOfferResource;
use App\Http\Resources\V1\Marketing\ClientOfferResource;
use App\Services\Marketing\OfferSerivce;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ClientOfferController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private OfferSerivce $offerService
    ) {}

    public function activeOffers()
    {
        $offers = $this->offerService->activeOffers();
        return $this->successCollection($offers, ClientOfferResource::class);
    }

    public function show(int $id)
    {
        $offer = $this->offerService->show($id);
        return $this->useResource($offer, ClientOfferResource::class);
    }
}
