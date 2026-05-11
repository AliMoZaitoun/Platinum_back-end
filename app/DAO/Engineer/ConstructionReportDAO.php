<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\CreateReportDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\ConstructionReport;

class ConstructionReportDAO
{
    public function index()
    {
        return ConstructionReport::latest('report_date')->with(['project', 'engineer'])->get();
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
        return ConstructionReport::where('id', $id)->with(['project', 'engineer'])->get() ?? throw new NotFoundException("Report");
    }

    public function findByUuid(string $uuid)
    {
        return ConstructionReport::where('uuid', $uuid)->with(['project', 'engineer'])->get()
            ?? throw new NotFoundException("Report");
    }

    public function destroy(int $id)
    {
        $report = $this->show($id);
        return $report->delete();
    }
}
