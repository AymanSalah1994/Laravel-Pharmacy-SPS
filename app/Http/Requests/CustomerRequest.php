<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'gender' => ['required', Rule::in(['male', 'female'])],
            'dob' => ['required', 'date'],
            'national_id' => ['required', 'string', 'min:11', 'max:11'],
            'profile_image' => ['required', 'image', 'max:2048'],
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
        ];
    }
}
