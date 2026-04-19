<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;
use App\Exceptions\NotFoundException;
use App\Models\Project;

class ProjectDAO
{
    public function index()
    {
        return Project::all();
    }

    public function store(CreateProjectDTO $projectDTO)
    {
        return Project::create($projectDTO->toArray());
    }

    public function show(int $id)
    {
        return Project::find($id) ?? throw new NotFoundException("Project");
    }

    public function update(int $id, UpdateProjectDTO $projectDTO)
    {
        $project = $this->show($id);
        return $project->update($projectDTO->toArray());
    }

    public function destroy($id)
    {
        $project = $this->show($id);
        return $project->delete();
    }
}
