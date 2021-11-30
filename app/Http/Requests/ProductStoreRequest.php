<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:25',
                Rule::unique('products', 'title'),
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'price' => [
                'required',
                'numeric'
            ],
            'stock' => [
                'nullable',
                'numeric'
            ],
            'categories' => [
                'nullable',
                'array'
            ],
            'image' => [
                'required',
                'file',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ]
        ];
    }
}
