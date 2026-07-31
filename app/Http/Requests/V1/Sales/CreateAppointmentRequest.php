<?php

namespace App\Http\Requests\V1\Sales;

use App\Enums\AppointmentType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'order_id'   => ['nullable', 'integer', 'exists:orders,id'],
            'av_slot_id' => ['required', 'integer', 'exists:availability_slots,id'],

            'client_id'  => $user && $user->type === 'employee'
                ? 'required|exists:clients,id'
                : 'nullable',

            'type'       => ['nullable', Rule::enum(AppointmentType::class)],
            'notes'      => ['required_without:order_id', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'notes.required_without' => __('messages.validation.appointment_notes_required'),
        ];
    }
}
