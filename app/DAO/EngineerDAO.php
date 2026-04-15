<?php

namespace App\DAO;

use App\DTOs\User\CreateEngineerDTO;
use App\Models\Engineer;

class EngineerDAO
{
    public function store(CreateEngineerDTO $engineerDTO)
    {
        return Engineer::create([
            'user_id' => $engineerDTO->user_id,
            'specialization' => $engineerDTO->specialization,
            'experience_years' => $engineerDTO->experience_years
        ]);
    }

    public function find($id)
    {
        return Engineer::find($id);
    }

    public function update($engineer, $data)
    {
        $engineer->update([
            'specialization' => $data['specialization'] ?? $engineer->specialization,
            'experience_years' => $data['experience_years'] ?? $engineer->experience_years,
        ]);
        return $engineer;
    }

    public function delete($id)
    {
        // Logic to delete an engineer from the database
    }
}
