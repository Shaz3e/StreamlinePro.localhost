<?php

namespace App\Http\Requests\Admin\Product;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('products', 'name')->ignore($this->product),
            ],
            'price' => [
                'required', 'numeric', 'gt:0',
            ],
            'description' => [
                'nullable', 'string',
            ],
            'is_active' => [
                'required', 'boolean',
            ],
        ];
    }
}
