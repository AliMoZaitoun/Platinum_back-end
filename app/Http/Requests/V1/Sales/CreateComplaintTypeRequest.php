<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateComplaintTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locale = app()->getLocale();
        return [
            'title' => [
                'required',
                Rule::unique('complaint_types', "title->{$locale}")->ignore($this->id),
            ],
        ];
    }
}
