<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Update\UpdateSolutionDTO;
use App\DTOs\RealEstate\Create\CreateSolutionDTO;
use App\Exceptions\NotFoundException;
use App\Models\RealEstate\Solution;

class SolutionDAO
{
    public function index()
    {
        return Solution::all();
    }

    public function store(array $data)
    {
        return Solution::create($data);
    }

    public function show(int $id)
    {
        return Solution::find($id) ?? throw new NotFoundException("Solution");
    }

    public function update(int $id, UpdateSolutionDTO $solutionDTO)
    {
        $solution = $this->show($id);
        $solution->update($solutionDTO->toArray());
        return $solution;
    }

    public function destroy(int $id)
    {
        $solution = $this->show($id);
        return $solution->delete();
    }
}
