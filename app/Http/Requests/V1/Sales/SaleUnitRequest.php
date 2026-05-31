<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaleUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'purchase_price' => ['required', 'numeric', 'min:0', 'max:999999999999.99'],
            'status'    => ['nullable', 'in:active,pending,transferred'],
            'owned_at'  => ['required', 'date']
        ];
    }
}
