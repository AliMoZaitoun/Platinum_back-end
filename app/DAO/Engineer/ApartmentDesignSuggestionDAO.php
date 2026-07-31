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
            'building_id'          => $data['building_id'] ?? null,
            'apartment_number'     => $data['apartment_number'] ?? null,
            'user_prompt'          => $data['prompt'],
            'design_style'         => $data['style'] ?? 'modern',
            'generated_image_urls' => $data['generated_image_urls'] ?? [],
        ]);
    }

    public function getByEngineerId(int $employeeId)
    {
        return ApartmentDesignSuggestion::where('employee_id', $employeeId)
            ->latest()
            ->paginate(15);
    }
}
