<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
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
            //
            'name' => 'required|string',
            // 'email' => [
            //     'required',
            //     'email',
            //     Rule::unique('users')->where(function ($query) {
            //         return $query->where('userable_id', $this->id)
            //                      ->where('userable_type', 'App\Models\Doctor');
            //     }),
            // ],
            'national_id'=>'required|integer|min:8',
            'password'=>'required|min:5'
        ];
    }
    public function messages(): array
    {
        return [
        "name.required" => 'The name is required',
        "email.required" => 'The email is required',
        "password.required" => 'The password is required',
        "national_id.required" => 'The national_id is required',
        // "email.unique" => 'email must be unique',
        "password.min" => 'The password is minmum 5 length',
        "national_id.min" => 'The password is minmum 8 length',
    ];
    }
}
