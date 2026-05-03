<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;
use App\Exceptions\NotFoundException;
use App\Models\ConstructionReport;
use App\Models\Project;

class ConstructionReportDAO
{
    public function index()
    {
        return ConstructionReport::all();
    }

    public function store(CreateProjectDTO $projectDTO)
    {
        return ConstructionReport::create($projectDTO->toArray());
    }

    public function show(int $id)
    {
        return ConstructionReport::find($id) ?? throw new NotFoundException("Project");
    }

    public function update(int $id, UpdateProjectDTO $projectDTO)
    {
        $project = $this->show($id);
        $project->update($projectDTO->toArray());
        return $project;
    }

    public function destroy($id)
    {
        $project = $this->show($id);
        return $project->delete();
    }
}
