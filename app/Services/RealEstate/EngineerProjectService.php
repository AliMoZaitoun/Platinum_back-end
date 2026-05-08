<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\EngineerProjectDAO;
use App\DTOs\RealEstate\Create\AssignEngProDTO;
use App\DTOs\RealEstate\Create\UpdateEngProDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class EngineerProjectService
{
    public function __construct(
        private EngineerProjectDAO $engineerProjectDAO
    ) {}

    public function index(array $relations = [])
    {
        return $this->engineerProjectDAO->index($relations);
    }

    public function store(AssignEngProDTO $dto)
    {
        return $this->engineerProjectDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->engineerProjectDAO->show($id);
    }

    public function myProjects()
    {
        $user = Auth::user();
        $eng = $user->engineer;
        return $this->engProjects($eng->id);
    }
    public function engProjects(int $id)
    {
        return $this->engineerProjectDAO->engProjects($id);
    }

    public function proEngineers(int $project_id)
    {
        return $this->engineerProjectDAO->proEngineers($project_id);
    }

    public function update(int $id, UpdateEngProDTO $dto)
    {
        return $this->engineerProjectDAO->update($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->engineerProjectDAO->destroy($id);
    }
}
