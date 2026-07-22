<?php

namespace App\Http\Requests\V1\Sales;

use App\Enums\TransactionCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'                 => ['nullable', 'string', Rule::in(['receipt', 'payment'])],

            'amount'               => ['nullable', 'numeric', 'gt:0'],
            'currency'             => ['nullable', 'string', 'size:3'],
            'exchange_rate'        => ['nullable', 'numeric', 'gt:0'],

            'category'             => ['nullable', Rule::enum(TransactionCategory::class)],
            'payment_method'       => ['nullable', 'string', Rule::in(['cash', 'bank_transfer', 'check', 'card'])],

            'party_type'           => ['nullable', 'string', 'max:255'],
            'party_id'             => ['nullable', 'integer', 'required_with:party_type'],

            'transactionable_type' => ['nullable', 'string', 'max:255'],
            'transactionable_id'   => ['nullable', 'integer', 'required_with:transactionable_type'],

            'status'               => ['nullable', 'string', Rule::in(['draft', 'posted'])],
            'description'          => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'voucher_number.required' => __('messages.transaction.voucher_number_required'),
            'voucher_number.unique'   => __('messages.transaction.voucher_number_unique'),
            'type.required'           => __('messages.transaction.type_required'),
            'type.in'                 => __('messages.transaction.type_invalid'),
            'amount.required'         => __('messages.transaction.amount_required'),
            'amount.gt'               => __('messages.transaction.amount_must_be_positive'),
            'category.required'       => __('messages.transaction.category_required'),
            'payment_method.required' => __('messages.transaction.payment_method_required'),
        ];
    }
}
