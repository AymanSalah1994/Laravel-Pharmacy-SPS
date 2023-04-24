<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerAdminUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'gender' => ['required', Rule::in(['Male', 'Female'])], //TODO M Capital
            'dob' => ['required', 'date'],
            'national_id' => ['required', 'string'],
            'mobile_number' => ['required', 'string'],
        ];
    }

    public function handleRequest()
    {
        $allRequestData = $this->validated();
        return $allRequestData;
    }
}
