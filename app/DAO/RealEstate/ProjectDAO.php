<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;
use App\Exceptions\NotFoundException;
use App\Models\RealEstate\Project;

class ProjectDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['location', 'attachments'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Project::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data)
    {
        return Project::create($data);
    }

    public function show(int $id)
    {
        return Project::find($id) ?? throw new NotFoundException("Project");
    }

    public function update(int $id, UpdateProjectDTO $projectDTO)
    {
        $project = $this->show($id);
        $project->update($projectDTO->toArray());
        return $project;
    }

    public function destroy(int $id)
    {
        $project = $this->show($id);
        return $project->delete();
    }
}
