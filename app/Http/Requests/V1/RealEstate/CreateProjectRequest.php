<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                            => 'required|string',
            'description'                     => 'nullable|string',
            'location_id'                     => 'required|integer|exists:locations,id',
            'latitude'                        => 'nullable|numeric|between:-90,90',
            'longitude'                       => 'nullable|numeric|between:-180,180',
            'radius_meters'                   => 'nullable|integer',
            'status'                          => 'required|in:completed,in_progress,stopped',
            'start_date'                      => 'required|date',
            'end_date'                        => 'nullable|date',
            'attachments'                     => ['nullable', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:360_panorama'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
