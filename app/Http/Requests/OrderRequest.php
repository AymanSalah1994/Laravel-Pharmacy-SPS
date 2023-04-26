<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "medicines"    => "required|array|min:1",
            'medicines.*' => 'string',
            "quantities"    => "required|array|min:1",
            'quantities.*' => 'numeric',
            "prices"    => "required|array|min:1",
            'prices.*' => 'numeric',
            "types"    => "required|array|min:1",
            'types.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
