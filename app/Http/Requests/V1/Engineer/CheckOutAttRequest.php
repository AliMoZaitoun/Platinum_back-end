<?php

namespace App\Http\Requests\V1\Engineer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckOutAttRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('engineer');
    }

    public function rules(): array
    {
        return [
            'uuid'               => 'required|string',
            'project_id'         => 'required|integer|exists:projects,id',
            'check_out_lat'      => 'required|numeric|between:-90,90',
            'check_out_lng'      => 'required|numeric|between:-180,180',
            'checked_out_at'     => 'required|date|date_format:Y-m-d H:i:s'
        ];
    }
}
