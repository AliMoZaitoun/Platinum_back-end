<?php

namespace App\Http\Requests\V1\Lottery;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLotteryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit_id' => [
                'required',
                'integer',
                'exists:units,id',
                Rule::unique('lotteries', 'unit_id')->where(function ($query) {
                    return $query->whereIn('status', ['open', 'closed']);
                }),
            ],

            'title' => 'required|string|max:255',
            'rules'                 => 'required|array|min:1',
            'rules.*.rule_key'      => 'required|string',
            'rules.*.operator'      => 'required|string|in:=,>=,<=,>,<,LIKE,IN',
            'rules.*.rule_value'    => 'required|string',
            'status'                => 'string|in:open'
        ];
    }

    public function messages(): array
    {
        return [
            'unit_id.unique'      => __('validation.custom.unit_id.unique'),
        ];
    }
}
