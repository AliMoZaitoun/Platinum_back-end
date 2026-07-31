<?php

namespace App\Http\Requests\V1\Engineer;

use Illuminate\Foundation\Http\FormRequest;

class GenerateDesignImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building_id'      => 'nullable|exists:buildings,id',
            'apartment_number' => 'nullable|string|max:50',
            'prompt'           => 'required|string|min:5|max:1000',
            'style'            => 'nullable|string|in:modern,classic,minimalist,industrial,bohemian',
        ];
    }

    public function messages(): array
    {
        return [
            'prompt.required' => 'يرجى تقديم وصف أو تفاصيل للتصميم المطلوب.',
            'prompt.min'      => 'التفاصيل يجب أن تكون 5 أحرف على الأقل.',
            'style.in'        => 'النمط المختار غير مدعوم.',
        ];
    }
}
