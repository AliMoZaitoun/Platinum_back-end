<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\Engineer\Create\CreateReportDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RealEstate\CreateReportRequest;
use App\Http\Resources\V1\RealEstate\ConstructionReportResource;
use App\Services\Engineer\ConstructionReportService;
use App\Traits\ResponseTrait;

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
        $report = $this->service->store($reportDTO, $request->file('attachments'));
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
