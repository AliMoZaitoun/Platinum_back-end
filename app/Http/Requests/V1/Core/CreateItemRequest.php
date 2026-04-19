<?php

namespace App\Http\Requests\V1\Core;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'sku' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:in_stock,out_of_stock,discontinued'],
            'expiry_date' => ['nullable', 'date'],
            'purchase_date' => ['required', 'date'],
            'received_date' => ['required', 'date'],
        ];
    }
}
