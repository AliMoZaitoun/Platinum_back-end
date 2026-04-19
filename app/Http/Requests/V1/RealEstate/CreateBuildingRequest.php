<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'building_number' => 'required|string',
            'floors_count' => 'required|integer',
            'status' => 'required'
        ];
    }
}
