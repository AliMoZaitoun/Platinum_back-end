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
            'engineer_id'           => 'required|exists:engineers,id',
            'phase'                 => 'required|in:excavation,foundation,structural,finishing,electrical,plumbing',
            'completion_percentage' => 'required|integer|min:0|max:100',
            'daily_progress'        => 'required|integer',
            'status'                => 'required|in:on_track,delayed,blocked',
            'report_date'           => 'required|date',
            'recorded_at'           => 'nullable|date',
            'attachments'           => 'nullable|array',
            'attachments.*'         => 'file|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip|max:10240',
        ];
    }
}
