<?php

namespace App\Http\Requests\V1\Client;

use App\Http\Requests\V1\SignUpRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge((new SignUpRequest())->rules(), [
            'birth_date' => ['required', 'date'],
            'job_title' => ['required', 'string', 'max:255'],
            'social_status' => ['required', 'string', 'in:single,married,divorced,widowed'],
            'national_id' => ['required', 'string', 'max:20', 'unique:clients'],
        ]);
    }
}
