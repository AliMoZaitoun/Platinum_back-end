<?php

namespace App\Http\Requests\V1\Sales\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('client');
    }

    public function rules(): array
    {
        return [
            'unit_id'               => 'nullable|exists:units,id',
            'complaint_type_id'     => 'nullable:new_type|prohibited_if:new_type,true|exists:complaint_types,id',
            'title'                 => 'nullable|string',
            'body'                  => 'nullable|text',

            'note'                 => 'nullable|string'
        ];
    }
}
