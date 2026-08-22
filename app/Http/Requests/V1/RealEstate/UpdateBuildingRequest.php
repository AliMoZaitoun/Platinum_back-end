<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'                      => 'nullable|exists:projects,id',
            'building_number'                 => 'nullable|string',
            'latitude'                        => 'nullable|numeric|between:-90,90',
            'longitude'                       => 'nullable|numeric|between:-180,180',
            'radius_meters'                   => 'nullable|integer',
            'location_id'                     => 'nullable|integer|exists:locations,id',
            'floors_count'                    => 'nullable|integer',
            'status'                          => 'nullable',
            'start_date'                      => 'nullable|date',
            'attachments'                     => ['nullable', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:360_panorama'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
