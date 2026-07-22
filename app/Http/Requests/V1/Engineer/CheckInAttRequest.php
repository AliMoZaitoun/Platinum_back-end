<?php

namespace App\Http\Requests\V1\Engineer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckInAttRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('engineer');
    }

    public function rules(): array
    {
        return [
            'uuid'          => 'required|uuid',
            'project_id'    => 'required|integer|exists:projects,id',
            'building_id'   => 'nullable|integer|exists:buildings,id',
            'check_in_lat'  => 'required|numeric|between:-90,90',
            'check_in_lng'  => 'required|numeric|between:-180,180',
            'checked_in_at' => 'required|date|date_format:Y-m-d H:i:s',
            'device_id'     => 'required|string|max:255',
            'is_mock'       => 'required|boolean',
            'gps_accuracy'  => 'required|numeric',
        ];
    }
}
