<?php

namespace App\Http\Requests\V1\Finance;

use Illuminate\Foundation\Http\FormRequest;

class PayCustomAmountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount'                          => ['required', 'numeric', 'min:1'],
            'payment_method'                  => ['required', 'string', 'in:cash,bank_transfer,check,card'],

            'attachments'                     => ['required', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:receipt,check_image,document'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
