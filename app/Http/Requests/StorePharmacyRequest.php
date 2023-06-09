<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePharmacyRequest extends FormRequest
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
            'name' => ['required', "max:255" ,"min:2"],
            'email' => ['required', "max:255",'unique:users,email','email'],
            'password' => ['required', "max:255",'min:6'],
            'national_id' => ['required','integer','digits:14','unique:pharmacies,national_id'],
            'avatar_image' => ['image', "max:255",'mimes:jpeg,jpg,png'],
            'area_id' => ["required", "exists:areas,id"],
            'priority' => ['required', 'integer', "min:0"],
            'userable_type' => ['required', Rule::in(['App\Models\Customer', 'App\Models\Admin', 'App\Models\Pharmacy', 'App\Models\Doctor'])],
        ];

    }
    public function messages()
    {
        return [
            'national_id.unique'=>'The national_id is invalid.',
            'area_id.exists' => "This area is invalid.",
            'area_id.required' => "The area is required."
        ];
    }
}
