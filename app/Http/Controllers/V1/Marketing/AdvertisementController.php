<?php

namespace App\Http\Controllers\V1\Marketing;

use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Marketing\CreateAdvertisementRequest;
use App\Http\Resources\V1\Marketing\AdvertismentResource;
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
        return $this->successCollection($ads, AdvertismentResource::class);
    }

    public function byStatus(int $status)
    {
        $ads = $this->adService->byStatus($status);
        return $this->successCollection($ads, AdvertismentResource::class);
    }

    public function store(CreateAdvertisementRequest $request)
    {
        $dto = CreateAdDTO::fromRequest($request->validated());

        $ad = $this->adService->store($dto);
        return $this->successResponse($ad, __('messages.common.stored'));
    }

    public function show(int $id)
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

    public function destroy(int $id)
    {
        $this->adService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
