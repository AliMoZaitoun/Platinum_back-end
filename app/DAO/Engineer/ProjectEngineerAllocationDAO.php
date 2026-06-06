<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\AssignEngineerAllocationDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\ProjectEngineerAllocation;

class ProjectEngineerAllocationDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['project', 'engineer', 'project.location', 'building', 'building.location'];
        $allRelations = array_merge($defaultRelations, $relations);

        return ProjectEngineerAllocation::with($allRelations)->paginate($perPage);
    }

    public function store(AssignEngineerAllocationDTO $dto)
    {
        return ProjectEngineerAllocation::create($dto->toArray());
    }

    public function show(int $id)
    {
        return ProjectEngineerAllocation::find($id) ?? throw new NotFoundException("Engineer-Project");
    }

    public function getProjectsAllocatedToEngineer(int $engineer_id)
    {
        return ProjectEngineerAllocation::where('engineer_id', $engineer_id)
            ->whereNull('building_id')
            ->with([
                'project',
                'project.location',
                'project.buildings' => function ($query) {
                    $query->where('status', 'in_progress');
                },
                'project.buildings.attachments'
            ])
            ->get();
    }

    public function getBuildingsAllocatedToEngineer(int $engineer_id)
    {
        return ProjectEngineerAllocation::where('engineer_id', $engineer_id)
            ->whereNotNull('building_id')
            ->with([
                'building',
                'building.location',
                'project'
            ])
            ->get();
    }

    public function getEngineersAllocatedToProject(int $project_id)
    {
        return ProjectEngineerAllocation::where('project_id', $project_id)
            ->whereNull('building_id')
            ->with('engineer')
            ->get();
    }

    public function getEngineersAllocatedToBuilding(int $building_id)
    {
        return ProjectEngineerAllocation::where('building_id', $building_id)
            ->with('engineer')
            ->get();
    }

    public function update(int $id, UpdateEngProDTO $dto)
    {
        $engPro = $this->show($id);
        $engPro->update($dto->toArray());
        return $engPro;
    }

    public function destroy(int $id)
    {
        return $this->show($id)->delete();
    }
}
