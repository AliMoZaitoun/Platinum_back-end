<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_date'                    => 'nullable|date',
            'payment_type'                    => 'nullable|string|in:down_payment,installment,final_payment,maintenance_fees',
            'payment_method'                  => 'nullable|string|in:cash,bank_transfer,check,card',

            'status'                          => 'nullable|in:pending,paid,failed,refunded',

            'attachments'                     => ['nullable', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:receipt,check_image,document'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
