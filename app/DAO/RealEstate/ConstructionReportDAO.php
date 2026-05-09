<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateReportDTO;
use App\Exceptions\NotFoundException;
use App\Models\ConstructionReport;

class ConstructionReportDAO
{
    public function index()
    {
        return ConstructionReport::latest('report_date')->get();
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
        return ConstructionReport::find($id) ?? throw new NotFoundException("Report");
    }

    public function findByUuid(string $uuid)
    {
        return ConstructionReport::where('uuid', $uuid)->first()
            ?? throw new NotFoundException("Report");
    }

    public function destroy(int $id)
    {
        $report = $this->show($id);
        return $report->delete();
    }
}
