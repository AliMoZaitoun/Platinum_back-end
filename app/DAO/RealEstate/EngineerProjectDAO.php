<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\AssignEngProDTO;
use App\DTOs\RealEstate\Create\UpdateEngProDTO;
use App\Exceptions\NotFoundException;
use App\Models\EngineerProject;

class EngineerProjectDAO
{
    public function index(array $relations = [])
    {
        $defaultRelations = ['project', 'engineer'];
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
        return EngineerProject::where('engineer_id', $enginner_id)->with('project')->get();
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

    public function destroy($id)
    {
        $engPro = $this->show($id);
        return $engPro->delete();
    }
}
