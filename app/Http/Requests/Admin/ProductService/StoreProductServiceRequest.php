<?php

namespace App\Http\Requests\Admin\ProductService;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreProductServiceRequest extends BaseFormRequest
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
                Rule::unique('products_services', 'name')->ignore($this->product_service),
            ],
            'price' => [
                'required', 'numeric', 'gt:0',
            ],
            'description' => [
                'nullable', 'string',
            ],
            'type' => [
                'nullable', 'max:255',
            ],
            'is_active' => [
                'required', 'boolean',
            ],
        ];
    }
}
