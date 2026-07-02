<?php

namespace App\Http\Requests\V1\Sales\Update;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'        => 'required|string|in:pending,initially_accepted,accepted,rejected',
        ];
    }
}
