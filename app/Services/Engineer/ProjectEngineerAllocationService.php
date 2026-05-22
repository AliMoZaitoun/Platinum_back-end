<?php

namespace App\Services\Engineer;

use App\DAO\Engineer\ProjectEngineerAllocationDAO;
use App\DTOs\Engineer\Create\AssignEngineerAllocationDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;

class ProjectEngineerAllocationService
{
    public function __construct(
        private ProjectEngineerAllocationDAO $allocationDAO
    ) {}

    public function index(array $relations = [])
    {
        return $this->allocationDAO->index($relations);
    }

    public function store(AssignEngineerAllocationDTO $dto)
    {
        return $this->allocationDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->allocationDAO->show($id);
    }

    public function engineerAllocations(int $engineerId)
    {
        $projectAllocations = $this->allocationDAO->getProjectsAllocatedToEngineer($engineerId);

        $buildingAllocations = $this->allocationDAO->getBuildingsAllocatedToEngineer($engineerId);

        return $projectAllocations->concat($buildingAllocations)
            ->sortByDesc('created_at')
            ->values();
    }

    public function getEngineersAllocatedToProject(int $project_id)
    {
        return $this->allocationDAO->getEngineersAllocatedToProject($project_id);
    }

    public function getEngineersAllocatedToBuilding(int $building_id)
    {
        return $this->allocationDAO->getEngineersAllocatedToBuilding($building_id);
    }


    public function update(int $id, UpdateEngProDTO $dto)
    {
        return $this->allocationDAO->update($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->allocationDAO->destroy($id);
    }
}
