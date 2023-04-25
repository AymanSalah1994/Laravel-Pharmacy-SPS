<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Pharmacy;
class UpdatePharmacyRequest extends FormRequest
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

        $pharmacy_id= Pharmacy::find(Request()->request->get('userable_id'));

        return [
            'name' => ['required', "max:255"],
            'email' => ['required', "max:255", 'email', Rule::unique('users')->ignore($pharmacy_id->users[0]->id)],
            'password' => ['required', "max:255",'min:6'],
            'national_id' => ['required','integer','digits:14', Rule::unique('pharmacies')->ignore($pharmacy_id->id)],
            'avatar_image' => ['image',"max:255",'mimes:jpeg,jpg,png'],
            'area_id' => ["required", "exists:areas,id"],
            'priority' => ['required', 'integer', 'min:0'],

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
    public function getPharmacyIdInUser()
    {
        return Auth::user()->roles[0]->name=='pharmacy' ?  $this->id : $this->pharmacy;
    }
}
