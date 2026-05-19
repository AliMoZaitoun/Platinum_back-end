<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit_id'     => 'required_without:solution_id|prohibited_if:solution_id,true|exists:units,id',
            'solution_id' => 'required_without:unit_id|prohibited_if:unit_id,true|exists:solutions,id'
        ];
    }
}
