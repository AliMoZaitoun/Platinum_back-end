<?php

namespace App\Http\Requests\V1\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();

        return [
            'order_id'   => 'required|exists:orders,id',
            'av_slot_id' => 'required|exists:availability_slots,id',

            'client_id'  => $user && $user->type !== 'client'
                ? 'required|exists:clients,id'
                : 'nullable',
        ];
    }
}
