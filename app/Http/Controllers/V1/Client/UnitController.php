<?php

namespace App\Http\Controllers\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RealEstate\ClientUnitResource;
use App\Services\RealEstate\UnitService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private UnitService $unitService
    ) {}

    public function index(int $perPage = 15)
    {
        $units = $this->unitService->getUnitsForClient($perPage);
        return $this->successCollection($units, ClientUnitResource::class);
    }

    public function getWithoutPag()
    {
        $units = $this->unitService->getWithoutPag();
        return $this->successCollection($units, ClientUnitResource::class);
    }

    public function byBuilding(int $building_id)
    {
        $units = $this->unitService->byBuilding($building_id, []);
        return $this->successCollection($units, ClientUnitResource::class);
    }

    public function show(int $id)
    {
        $unit = $this->unitService->show($id);
        return $this->useResource($unit, ClientUnitResource::class);
    }

    public function search(Request $request)
    {
        $units = $this->unitService->search($request->all());
        return $this->successCollection($units, ClientUnitResource::class);
    }
}
