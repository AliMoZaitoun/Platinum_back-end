<?php

namespace App\Http\Requests\V1\Legal;

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
            'reference_number'           => ['required', 'string', 'unique:contracts,reference_number'],
            'order_id'                   => ['required', 'integer', 'exists:orders,id'],
            'total_price'                => ['required', 'numeric', 'min:0'],
            'down_payment_amount'        => ['required', 'numeric', 'min:0', 'lte:total_price'],
            'installments_count'         => ['required', 'integer', 'min:1'],

            'has_exception'              => ['required', 'boolean'],

            'original_total_price'       => ['required_if:has_exception,true', 'nullable', 'numeric', 'min:0'],
            'original_down_payment'      => ['required_if:has_exception,true', 'nullable', 'numeric', 'min:0'],
            'original_installments_count' => ['required_if:has_exception,true', 'nullable', 'integer', 'min:1'],
            'exception_reason'           => ['required_if:has_exception,true', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'exception_reason.required_if'     => __('messages.legal.exception_reason_required'),
            'original_total_price.required_if' => __('messages.legal.original_total_price_required'),
            'down_payment_amount.lte'          => __('messages.legal.down_payment_lte_total'),
        ];
    }
}
