<?php

namespace App\Http\Requests\V1\Chat\Faq;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaqNodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'max:255'],
            'type'       => ['required', 'in:category,answer,action_human'],
            'parent_id'  => ['nullable', 'exists:faq_nodes,id'],
            'content'    => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
