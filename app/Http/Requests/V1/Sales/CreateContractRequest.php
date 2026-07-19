<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id'                        => 'required|integer|exists:orders,id',
            'client_id'                       => 'required|integer|exists:clients,id',
            'total_price'                     => 'required|numeric|min:0|max:999999999999.99',
            'down_payment_amount'             => 'required|numeric',
            'installments_count'              => 'required|integer',
            'status'                          => 'nullable|in:draft,active,completed,terminated',

            'attachments'                     => ['required', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:receipt,check_image,document'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
