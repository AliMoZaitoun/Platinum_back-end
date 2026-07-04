<?php

namespace App\Http\Requests\V1\Marketing;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ad_id'                 => ['nullable', 'integer', 'exists:advertisments,id'],
            'discount_percentage'   => ['required', 'numeric', 'min:0', 'max:100'],

            'starts_at'             => ['nullable', 'date', 'date_format:Y-m-d H:i:s'],
            'duration_days'         => ['required', 'integer', 'min:1'],
            'status'                => ['nullable', 'boolean'],
        ];
    }
}
