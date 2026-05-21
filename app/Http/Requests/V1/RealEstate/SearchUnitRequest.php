<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id' => 'nullable|integer',
            'rooms_count' => 'nullable|integer',
            'floor'       => 'nullable|integer',
            'area_min'    => 'nullable|numeric',
            'area_max'    => 'nullable|numeric',
            'type'        => 'nullable|string',
            'price_min'   => 'nullable|numeric',
            'price_max'   => 'nullable|numeric',
        ];
    }
}
