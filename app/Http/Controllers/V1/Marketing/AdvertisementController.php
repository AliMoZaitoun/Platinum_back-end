<?php

namespace App\Http\Controllers\V1\Marketing;

use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Marketing\CreateAdvertisementRequest;
use App\Http\Resources\V1\Marketing\AdminAdvertisementResource;
use App\Http\Resources\V1\Marketing\AdvertismentResource;
use App\Http\Resources\V1\Marketing\ClientAdvertisementResource;
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
        return $this->successCollection($ads, AdminAdvertisementResource::class);
    }

    public function getActiveAdvertisements()
    {
        $ads = $this->adService->getActiveAdvertisements();
        return $this->successCollection($ads, ClientAdvertisementResource::class);
    }

    public function store(CreateAdvertisementRequest $request)
    {
        $dto = CreateAdDTO::fromRequest($request->validated());

        $ad = $this->adService->store($dto, $request->file('attachments'));
        return $this->useResource($ad, AdminAdvertisementResource::class, __('messages.common.stored'), 201);
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
