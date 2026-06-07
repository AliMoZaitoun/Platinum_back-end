<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\CreateEngineerDTO;
use App\DTOs\Engineer\Update\UpdateEngineerDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\Engineer;

class EngineerDAO
{

    public function index()
    {
        return Engineer::all();
    }

    public function store(CreateEngineerDTO $engineerDTO)
    {
        $engineer = Engineer::create($engineerDTO->toArray());
        $engineer->user->assignRole('engineer');
        return $engineer;
    }

    public function show(int $id)
    {
        return Engineer::find($id) ?? throw new NotFoundException("Engineer");
    }

    public function update(int $id, UpdateEngineerDTO $engineerDTO)
    {
        $engineer = $this->show($id);
        return $engineer->update($engineerDTO->toArray());
    }

    public function destroy(int $id)
    {
        $engineer = $this->show($id);
        return $engineer->user->delete();
    }
}
