<?php

namespace App\Services\Core;

use App\DAO\Core\SolutionDAO;
use App\DTOs\Core\CreateSolutionDTO;
use App\DTOs\Core\Update\UpdateSolutionDTO;

class SolutionService
{
    public function __construct(
        private SolutionDAO $solutionDAO
    ) {}

    public function store(CreateSolutionDTO $SolutionDTO)
    {
        return $this->solutionDAO->store($SolutionDTO);
    }

    public function index()
    {
        return $this->solutionDAO->index();
    }

    public function show(int $id)
    {
        return $this->solutionDAO->show($id);
    }

    public function update(int $id, UpdateSolutionDTO $SolutionDTO)
    {
        return $this->solutionDAO->update($id, $SolutionDTO);
    }

    public function destroy($id)
    {
        return $this->solutionDAO->destroy($id);
    }
}
