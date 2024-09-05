<?php

namespace App\Http\Requests\Admin\Company;

use App\Http\Requests\BaseFormRequest;
use App\Models\Company;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends BaseFormRequest
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
                'max:100',
                Rule::unique('companies', 'name')->ignore($this->company),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('companies', 'email')->ignore($this->company),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('companies', 'phone')->ignore($this->company),
            ],
            'website' => [
                'nullable',
                'url',
                'max:255',
            ],
            'country' => [
                'nullable',
                'max:255',
            ],
            'address' => [
                'nullable',
                'max:255',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
            'logo' => [
                'nullable',
                'mimes:jpeg,png',  // Allow only JPEG and PNG mime types
                'max:2048',  // Maximum file size of 2 MB
            ],
        ];
    }
}
