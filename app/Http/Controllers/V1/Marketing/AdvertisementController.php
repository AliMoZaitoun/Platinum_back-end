<?php

namespace App\Http\Controllers;

use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Http\Requests\V1\Marketing\CreateAdvertisementRequest;
use App\Services\Marketing\AdvertismentSerivce;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private AdvertismentSerivce $adService
    ) {}

    public function index()
    {
        $ads = $this->adService->index();
        return $this->successResponse($ads);
    }

    public function store(CreateAdvertisementRequest $request)
    {
        $dto = CreateAdDTO::fromRequest($request->validated());

        $ad = $this->adService->store($dto);
        return $this->successResponse($ad, __('messages.common.stored'));
    }

    public function show($id)
    {
        $ad = $this->adService->show($id);
        return $this->successResponse($ad);
    }


    public function update(int $id, Request $request)
    {
        $dto = UpdateAdDTO::fromRequest($request->all());

        $ad = $this->adService->update($id, $dto);
        return $this->successResponse($ad, __('messages.common.updated'));
    }

    public function destroy($id)
    {
        $this->adService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
