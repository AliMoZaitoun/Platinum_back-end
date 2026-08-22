<?php

namespace App\Http\Requests\V1\Engineer;

use Illuminate\Foundation\Http\FormRequest;

class GenerateDesignFromImageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit_id'          => ['required', 'integer', 'exists:units,id'],
            'style'            => ['nullable', 'string'],
            'prompt'           => ['required', 'string'],
            'image'            => ['required', 'image', 'mimes:jpeg,png,jpg,webp,avif', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required'      => 'يرجى إرفاق صورة الشقة الفاضية.',
            'image.image'         => 'الملف المرفق يجب أن يكون صورة صالحة.',
            'image.max'           => 'حجم الصورة يجب أن لا يتجاوز 10 ميغابايت.',
            'prompt.required'     => 'يرجى كتابة تفاصيل الفرش والديكور المطلوب.',
            'prompt.min'          => 'تفاصيل الديكور يجب أن لا تقل عن 5 أحرف.',
            'style.in'            => 'النمط المختار غير مدعوم.',
        ];
    }
}
