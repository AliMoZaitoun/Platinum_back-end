<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EngineerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge([
            'specialization' => ['required', 'string'],
            'experience_years' => ['required', 'integer', 'min:0'],
        ], (new SignUpRequest())->rules());
    }
}
