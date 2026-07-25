<?php

namespace App\Http\Requests\V1\Legal;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'    => 'required|in:draft,active,completed,terminated'
        ];
    }
}
