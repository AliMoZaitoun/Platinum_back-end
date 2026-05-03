<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateLocationDTO;
use App\DTOs\RealEstate\Update\UpdateLocationDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RealEstate\LocationResource;
use App\Services\RealEstate\LocationService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private LocationService $locationService
    ) {}

    public function index()
    {
        $locations = $this->locationService->index();
        return $this->successCollection($locations, LocationResource::class);
    }

    public function store(Request $request)
    {
        $dto = CreateLocationDTO::fromRequest($request->all());
        $location = $this->locationService->store($dto);
        return $this->useResource($location, LocationResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $location = $this->locationService->show($id);
        return $this->useResource($location, LocationResource::class);
    }

    public function update(int $id, Request $request)
    {
        $dto = UpdateLocationDTO::fromRequest($request->all());
        $location = $this->locationService->update($id, $dto);
        return $this->useResource($location, LocationResource::class, __('messages.common.updated'), 200);
    }

    public function destroy($id)
    {
        $this->locationService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
