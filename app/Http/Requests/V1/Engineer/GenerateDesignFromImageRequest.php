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
            'building_id'      => ['required', 'integer'],
            'apartment_number' => ['required', 'string'],
            'style'            => ['nullable', 'string'],
            'prompt'           => ['required', 'string'],
            'image'            => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'original_image_url.required' => 'يرجى تقديم رابط صورة الشقة الفاضية.',
            'original_image_url.url'      => 'رابط الصورة يجب أن يكون رابطاً صحيحاً (URL).',
            'prompt.required'             => 'يرجى كتابة تفاصيل الفرش والديكور المطلوب.',
            'prompt.min'                  => 'تفاصيل الديكور يجب أن لا تقل عن 5 أحرف.',
            'style.in'                    => 'النمط المختار غير مدعوم.',
        ];
    }
}
