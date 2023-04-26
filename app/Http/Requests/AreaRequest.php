<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string'],
            'country_id'      => ['exists:countries,id'],
        ];
    }
    public function handleRequest()
    {
        $allRequestData = $this->validated();
        return $allRequestData;
    }

}
