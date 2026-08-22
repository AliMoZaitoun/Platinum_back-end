<?php

namespace App\DAO\Engineer;

use App\Models\ApartmentDesignSuggestion;
use Illuminate\Support\Str;

class ApartmentDesignSuggestionDAO
{
    public function create(array $data): ApartmentDesignSuggestion
    {
        return ApartmentDesignSuggestion::create([
            'uuid'                 => (string) Str::uuid(),
            'employee_id'          => $data['employee_id'],
            'unit_id'              => $data['unit_id'] ?? null,
            'user_prompt'          => $data['user_prompt'],
            'design_style'         => $data['design_style'] ?? 'modern',
            'generated_image_urls' => $data['generated_image_urls'] ?? [],
        ]);
    }

    public function getByEmployeeId(int $employeeId)
    {
        return ApartmentDesignSuggestion::where('employee_id', $employeeId)
            ->latest()
            ->paginate(15);
    }

    public function findById(int $id): ApartmentDesignSuggestion
    {
        return ApartmentDesignSuggestion::findOrFail($id);
    }
}
