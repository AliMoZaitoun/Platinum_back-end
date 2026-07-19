<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contract_id'                     => 'required|integer|exists:contracts,id',
            'client_id'                       => 'required|integer|exists:clients,id',
            'amount'                          => 'required|numeric|min:0|max:999999999999.99',
            'payment_date'                    => 'required|date',
            'payment_type'                    => 'required|string|in:down_payment,installment,final_payment,maintenance_fees',
            'payment_method'                  => 'required|string|in:cash,bank_transfer,check,card',

            'status'                          => 'nullable|in:pending,paid,failed,refunded',

            'attachments'                     => ['required', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:receipt,check_image,document'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
