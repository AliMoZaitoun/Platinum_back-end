<?php

namespace App\Http\Requests\V1\Chat;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'chat_room_id'  => 'required|exists:chat_rooms,id',
            'content'       => 'required|string|max:5000',
        ];
    }
}
