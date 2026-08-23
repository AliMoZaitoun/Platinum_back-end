<?php

namespace App\Http\Requests\V1\Finance;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_date'                    => 'nullable|date',
            'payment_type'                    => 'nullable|string|in:down_payment,installment,final_payment,maintenance_fees',
            'payment_method'                  => 'nullable|string|in:cash,bank_transfer,check,card',

            'status'                          => 'required|in:pending,paid,failed,refunded',
        ];
    }
}
