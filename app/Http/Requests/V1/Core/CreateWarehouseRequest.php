<?php

namespace App\Http\Requests\V1\Core;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateWarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'location_id' => 'required|integer|exists:locations,id',
            'address'     => 'required|string',
            'description' => 'nullable|string',
        ];
    }
}
