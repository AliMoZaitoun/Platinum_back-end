<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building_id' => 'required|exists:buildings,id',
            'unit_number' => 'required|string',
            'floor' => 'required|integer',
            'area'  => 'required|decimal:0,3',
            'type' => 'required|in:social,vip',
            'price' => 'required|decimal:0,3',
            'status' => 'required|in:available,reserved,sold,maintenance'
        ];
    }
}
