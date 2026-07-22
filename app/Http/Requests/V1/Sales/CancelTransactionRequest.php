<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Foundation\Http\FormRequest;

class CancelTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'min:5', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => __('messages.transaction.cancel_reason_required'),
            'reason.min'      => __('messages.transaction.cancel_reason_min'),
        ];
    }
}
