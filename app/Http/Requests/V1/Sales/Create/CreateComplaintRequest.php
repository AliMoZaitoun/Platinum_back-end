<?php

namespace App\Http\Requests\V1\Sales\Create;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('client');
    }

    public function rules(): array
    {
        return [
            'unit_id'           => 'nullable|exists:units,id',
            'complaint_type_id'     => 'required_without:new_type|prohibited_if:new_type,true|exists:complaint_types,id',
            'new_type'              => 'required_without:complaint_type_id|prohibited_if:complaint_type_id,true',
            'title'                 => 'required|string',
            'body'                  => 'required|string'
        ];
    }
}
