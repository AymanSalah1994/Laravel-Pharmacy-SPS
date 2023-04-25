<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'area_id' => 'required|exists:areas,id',
            'customer_id' => 'required|exists:users,id',
            'street_name' => 'required|string',
            'building_number' => 'required|integer',
            'floor_number' => 'required|integer',
            'flat_number' => 'required|string',
            'is_main' => 'required|boolean',
        ];
    }
}
