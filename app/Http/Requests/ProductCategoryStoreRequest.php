<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique('product_categories', 'name'),
            ]
        ];
    }
}
