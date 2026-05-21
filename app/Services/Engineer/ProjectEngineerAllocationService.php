<?php

namespace App\Services\Engineer;

use App\DAO\Engineer\ProjectEngineerAllocationDAO;
use App\DAO\RealEstate\ProjectDAO;
use App\DTOs\Engineer\Create\AssignEngineerAllocationDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;
use Illuminate\Support\Facades\Auth;

class ProjectEngineerAllocationService
{
    public function __construct(
        private ProjectEngineerAllocationDAO $allocationDAO,
        private ProjectDAO $projectDAO
    ) {}

    public function index(array $relations = [])
    {
        return $this->allocationDAO->index($relations);
    }

    public function store(AssignEngineerAllocationDTO $dto)
    {
        if ($dto?->building_id) {
            $allocations = [
                [
                    'engineer_id' => $dto->engineer_id,
                    'project_id'  => $dto->project_id,
                    'building_id' => $dto->building_id,
                    'start_date'  => $dto->start_date,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            ];
        } else {
            $project = $this->projectDAO->show($dto->project_id);
            $buildingIds = $project->buildings()->pluck('id');

            if ($buildingIds->isEmpty()) {
                throw new \Exception("المشروع لا يحتوي على أبنية لتخصيص المهندس بها.");
            }

            $allocations = $buildingIds->map(function ($buildingId) use ($dto) {
                return [
                    'engineer_id' => $dto->engineer_id,
                    'project_id'  => $dto->project_id,
                    'building_id' => $buildingId,
                    'start_date'  => $dto->start_date,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            })->toArray();
        }

        return $this->allocationDAO->storeMultiple($allocations);
    }

    public function show(int $id)
    {
        return $this->allocationDAO->show($id);
    }

    public function myProjects()
    {
        $user = Auth::user();
        $eng = $user->engineer;
        return $this->engProjects($eng->id);
    }

    public function engProjects(int $id)
    {
        return $this->allocationDAO->engProjects($id);
    }

    public function proEngineers(int $project_id)
    {
        return $this->allocationDAO->proEngineers($project_id);
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
