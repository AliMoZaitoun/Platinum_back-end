<?php

namespace App\Http\Requests\V1\Marketing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'advertisement_id'    => ['nullable', 'integer', 'exists:advertisements,id'],
            'discount_percentage' => ['required', 'numeric', 'min:0.01', 'max:100'],

            'start_date'          => ['nullable', 'date'],
            'duration_days'       => ['required', 'integer', 'min:1'],
            'status'              => ['nullable', 'boolean'],

            'offerable_type'      => ['required', 'string', Rule::in(['unit', 'solution'])],
            'offerable_id'        => ['required', 'integer', 'min:1'],
        ];
    }
}
