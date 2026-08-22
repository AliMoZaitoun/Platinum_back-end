<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building_id'                     => 'nullable|exists:buildings,id',
            'unit_number'                     => 'nullable|string',
            'floor'                           => 'nullable|integer',
            'area'                            => 'nullable|decimal:0,3',
            'type'                            => 'nullable|in:social,vip',
            'price'                           => 'nullable|numeric|min:0|max:999999999999.99',
            'status'                          => 'nullable|in:available,reserved,sold,maintenance',
            'attachments'                     => ['nullable', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:360_panorama'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
