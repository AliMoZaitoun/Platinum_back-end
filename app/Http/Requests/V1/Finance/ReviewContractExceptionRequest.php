<?php

namespace App\Http\Requests\V1\Finance;

use Illuminate\Foundation\Http\FormRequest;

class ReviewContractExceptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'           => ['required', 'string', 'in:approved,rejected'],
            'rejection_reason' => ['required_if:status,rejected', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in'                  => __('messages.finance.invalid_status'),
            'rejection_reason.required_if' => __('messages.finance.rejection_reason_required'),
        ];
    }
}
