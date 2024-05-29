<?php

namespace App\Http\Requests\Admin\Currency;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreCurrencyRequest extends BaseFormRequest
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
                'required',
                'string',
                'max:3',
                Rule::unique('currencies', 'name')->ignore($this->currency),
            ],
            'symbol' => [
                'required',
                'max:12',
            ],
            'is_active' => [
                'required', 'boolean'
            ]
        ];
    }
}
