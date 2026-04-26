<?php

namespace App\DAO\Core;

use App\DTOs\Core\CreateSolutionDTO;
use App\DTOs\Core\Update\UpdateSolutionDTO;
use App\Exceptions\NotFoundException;
use App\Models\Solution;

class SolutionDAO
{
    public function index()
    {
        return Solution::all();
    }

    public function store(CreateSolutionDTO $solutionDTO)
    {
        return Solution::create($solutionDTO->toArray());
    }

    public function show($id)
    {
        return Solution::find($id) ?? throw new NotFoundException("Solution");
    }

    public function update(int $id, UpdateSolutionDTO $solutionDTO)
    {
        $solution = $this->show($id);
        $solution->update($solutionDTO->toArray());
        return $solution;
    }

    public function destroy($id)
    {
        $solution = $this->show($id);
        return $solution->delete();
    }
}
