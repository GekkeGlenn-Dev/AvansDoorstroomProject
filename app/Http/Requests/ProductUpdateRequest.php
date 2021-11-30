<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'title' => [
                'required',
                'string',
                'max:25',
                Rule::unique('products', 'title')->ignore($product->id),
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
            'image' => [
                'nullable',
                'file',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ]
        ];
    }
}
