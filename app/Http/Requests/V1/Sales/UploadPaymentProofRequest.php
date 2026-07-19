<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadPaymentProofRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attachments'                     => ['required', 'array'],
            'attachments.*.file'              => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx,xlsx,zip,txt', 'max:10240'],
            'attachments.*.type'              => ['nullable', 'string', 'in:receipt,check_image,document'],
            'attachments.*.custom_properties' => ['nullable', 'array'],
        ];
    }
}
