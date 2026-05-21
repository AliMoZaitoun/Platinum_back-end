<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\AssignEngineerAllocationDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\ProjectEngineerAllocation;

class ProjectEngineerAllocationDAO
{
    public function index(array $relations = [])
    {
        $defaultRelations = ['project', 'engineer', 'project.location'];
        $allRelations = array_merge($defaultRelations, $relations);

        return ProjectEngineerAllocation::with($allRelations)->get();
    }

    public function storeMultiple(array $data)
    {
        return ProjectEngineerAllocation::insert($data);
    }

    public function store(AssignEngineerAllocationDTO $dto)
    {
        return ProjectEngineerAllocation::create($dto->toArray());
    }

    public function show(int $id)
    {
        return ProjectEngineerAllocation::find($id) ?? throw new NotFoundException("Engineer Project");
    }

    public function engProjects(int $enginner_id)
    {
        $relations = ['building', 'building.location'];
        return ProjectEngineerAllocation::where('engineer_id', $enginner_id)->with($relations)->get();
    }

    public function proEngineers(int $project_id)
    {
        return ProjectEngineerAllocation::where('project_id', $project_id)->with('engineer')->get();
    }

    public function update(int $id, UpdateEngProDTO $dto)
    {
        $engPro = $this->show($id);
        $engPro->update($dto->toArray());
        return $engPro;
    }

    public function destroy(int $id)
    {
        $engPro = $this->show($id);
        return $engPro->delete();
    }
}
