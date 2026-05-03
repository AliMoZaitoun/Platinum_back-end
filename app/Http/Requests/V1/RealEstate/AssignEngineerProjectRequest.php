<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignEngineerProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'engineer_id' => 'required|integer|exists:employees,id',
            'project_id' => 'required|integer|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date'
        ];
    }
}
