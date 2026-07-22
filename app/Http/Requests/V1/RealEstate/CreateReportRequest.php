<?php

namespace App\Http\Requests\V1\RealEstate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid'                  => 'required|uuid|unique:construction_reports,uuid',
            'project_id'            => 'required|exists:projects,id',
            'building_id'           => 'nullable|exists:buildings,id',
            'engineer_id'           => 'nullable|exists:engineers,id',
            'phase'                 => 'required|in:excavation,foundation,structural,finishing,electrical,plumbing',
            'completion_percentage' => 'required|numeric|min:0|max:100',
            'daily_progress'        => 'required|numeric',
            'status'                => 'required|in:on_track,delayed,blocked',
            'report_date'           => 'required|date',
            'manpower_count'        => 'required|integer',
            'issues_count'          => 'required|integer',
            'description'           => 'nullable|string',
            'recorded_at'           => 'nullable|date',
            'attachments'                     => ['nullable', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:360_panorama'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
