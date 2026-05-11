<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\AssignEngProDTO;
use App\DTOs\Engineer\Update\UpdateEngProDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\EngineerProject;

class EngineerProjectDAO
{
    public function index(array $relations = [])
    {
        $defaultRelations = ['project', 'engineer', 'project.location'];
        $allRelations = array_merge($defaultRelations, $relations);

        return EngineerProject::with($allRelations)->get();
    }

    public function store(AssignEngProDTO $dto)
    {
        return EngineerProject::create($dto->toArray());
    }

    public function show(int $id)
    {
        return EngineerProject::find($id) ?? throw new NotFoundException("Engineer Project");
    }

    public function engProjects(int $enginner_id)
    {
        return EngineerProject::where('engineer_id', $enginner_id)->with(['project', 'project.location', 'project.buildings'])->get();
    }

    public function proEngineers(int $project_id)
    {
        return EngineerProject::where('project_id', $project_id)->with('engineer')->get();
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
