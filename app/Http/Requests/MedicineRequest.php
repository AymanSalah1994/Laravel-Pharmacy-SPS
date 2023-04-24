<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
            'name' => 'required|string',
            'price' => 'required|numeric',
        ];
    }

    public function handleRequest()
    {
        $allRequestData = $this->validated();
        return $allRequestData;
    }
}
