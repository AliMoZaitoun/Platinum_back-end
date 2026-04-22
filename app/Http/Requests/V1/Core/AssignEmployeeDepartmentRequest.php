<?php

namespace App\Http\Requests\V1\Core;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignEmployeeDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:employees,id',
            'department_id' => 'required|integer|exists:departments,id',
            'position' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date'
        ];
    }
}
