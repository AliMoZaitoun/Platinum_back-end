<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAvailableSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'       => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i:s,H:i'],
            'end_time'   => ['required', 'date_format:H:i:s,H:i', 'after:start_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.after_or_equal' => __('messages.validation.date_cannot_be_in_past'),
            'end_time.after'     => __('messages.validation.end_time_must_be_after_start'),
        ];
    }
}
