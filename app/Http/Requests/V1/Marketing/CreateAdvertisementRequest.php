<?php

namespace App\Http\Requests\V1\Marketing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAdvertisementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'starts_at'     => ['nullable', 'date', 'date_format:Y-m-d H:i:s'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'status'        => ['nullable', 'boolean'],
            'created_by'    => ['nullable'],
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt|max:10240',
        ];
    }
}
