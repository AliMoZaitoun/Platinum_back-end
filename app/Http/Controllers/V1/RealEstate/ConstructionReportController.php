<?php

namespace App\Http\Controllers\V1\RealEstate;

use App\DTOs\RealEstate\Create\CreateReportDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateReportRequest;
use App\Http\Resources\V1\RealEstate\ConstructionReportResource;
use App\Services\RealEstate\ConstructionReportService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ConstructionReportController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private ConstructionReportService $service
    ) {}

    public function index()
    {
        $reports = $this->service->index();

        return $this->successCollection($reports, ConstructionReportResource::class);
    }

    public function store(CreateReportRequest $request)
    {
        $reportDTO = CreateReportDTO::fromRequest($request->validated());
        $report = $this->service->store($reportDTO);
        return $this->useResource($report, ConstructionReportResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $report = $this->service->show($id);
        return $this->useResource($report, ConstructionReportResource::class);
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'), 200);
    }
}
