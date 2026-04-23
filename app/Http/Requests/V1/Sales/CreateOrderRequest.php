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
            'unit_id'     => 'required_without:offering_id|prohibited_if:offering_id,true|exists:units,id',
            'offering_id' => 'required_without:unit_id|prohibited_if:unit_id,true|exists:offerings,id'
        ];
    }
}
