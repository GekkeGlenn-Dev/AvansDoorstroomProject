<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BasketCheckoutFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255'
            ],
            'email' => [
                'required',
                'max:255'
            ],
            'street' => [
                'required',
                'max:255'
            ],
            'house_number' => [
                'required',
                'numeric'
            ],
            'house_number_addition' => [
                'nullable',
                'string',
                'max:15'
            ],
            'postal_code' => [
                'required',
                'max:7',
                'min:6'
            ],
            'city' => [
                'required',
                'max:255'
            ],
            'country' => [
                'required',
                'max:255'
            ],
        ];
    }
}
