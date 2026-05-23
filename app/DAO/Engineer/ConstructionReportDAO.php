<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\CreateReportDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\ConstructionReport;

class ConstructionReportDAO
{
    public function index(int $perPage = 15)
    {
        return ConstructionReport::query()
            ->with(['project', 'engineer'])
            ->latest('report_date')
            ->paginate($perPage);
    }

    public function store(CreateReportDTO $dto)
    {
        return ConstructionReport::updateOrCreate(
            ['uuid' => $dto->uuid],
            $dto->toArray()
        );
    }

    public function show(int $id)
    {
        return ConstructionReport::where('id', $id)->with(['project', 'engineer'])->first() ?? throw new NotFoundException("Report");
    }

    public function engReports(int $engineer_id, ?int $project_id = null)
    {
        $reports = ConstructionReport::where('engineer_id', $engineer_id)
            ->with(['project', 'engineer'])
            ->when($project_id, function ($query, $projectId) {
                return $query->where('project_id', $projectId);
            })
            ->get();

        return $reports;
    }

    public function findByUuid(string $uuid)
    {
        return ConstructionReport::where('uuid', $uuid)->with(['project', 'engineer'])->first()
            ?? throw new NotFoundException("Report");
    }

    public function destroy(int $id)
    {
        $report = $this->show($id);
        return $report->delete();
    }
}
