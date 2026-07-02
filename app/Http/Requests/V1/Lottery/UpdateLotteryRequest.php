<?php

namespace App\Http\Requests\V1\Lottery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLotteryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit_id' => 'required|integer|exists:units,id',
            'title' => 'required|string|max:255',
            'rules' => 'required|array|min:1',
            'rules.*.rule_key' => 'required|string',
            'rules.*.operator' => 'required|string|in:=,>=,<=,>,<,LIKE,IN',
            'rules.*.rule_value' => 'required|string',
            'status'    => 'string|in:open,closed,completed'
        ];
    }
}
