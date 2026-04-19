<?php

namespace App\DAO\User;

use App\DTOs\User\CreateEngineerDTO;
use App\DTOs\User\Update\UpdateEngineerDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer;

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

    public function show($id)
    {
        return Engineer::find($id) ?? throw new NotFoundException("Engineer");
    }

    public function update($engineer, UpdateEngineerDTO $engineerDTO)
    {
        return $engineer->update($engineerDTO->toArray());
    }

    public function destroy($id)
    {
        $engineer = $this->show($id);
        return $engineer->user->delete();
    }
}
