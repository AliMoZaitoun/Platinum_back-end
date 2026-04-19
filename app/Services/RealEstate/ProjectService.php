<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\ProjectDAO;
use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;

class ProjectService
{
    public function __construct(
        private ProjectDAO $projectDAO
    ) {}

    public function index()
    {
        return $this->projectDAO->index();
    }

    public function store(CreateProjectDTO $projectDTO)
    {
        return $this->projectDAO->store($projectDTO);
    }

    public function show(int $id)
    {
        return $this->projectDAO->show($id);
    }

    public function update(int $id, UpdateProjectDTO $projectDTO)
    {
        return $this->projectDAO->update($id, $projectDTO);
    }

    public function destroy($id)
    {
        return $this->projectDAO->destroy($id);
    }
}
