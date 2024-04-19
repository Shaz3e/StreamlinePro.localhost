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
                'required', 'string', 'max:255',
                Rule::unique('companies', 'name')->ignore($this->company),
            ],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('companies', 'email')->ignore($this->company),
            ],
            'phone' => [
                'nullable', 'string', 'max:255',
                Rule::unique('companies', 'phone')->ignore($this->company),
            ],
            'website' => [
                'nullable', 'url', 'max:255',
            ],
            'country' => [
                'nullable', 'max:255',
            ],
            'address' => [
                'nullable', 'max:255',
            ],
            'is_active' => [
                'required', 'boolean',
            ],
            'logo' => [
                'nullable',
                'image',  // Ensure it is an image file
                'mimes:jpeg,png',  // Allow only JPEG and PNG mime types
                'max:2048',  // Maximum file size of 2 MB
                function ($attribute, $value, $fail) {
                    // Custom validation rule to check if the image is square
                    list($width, $height) = getimagesize($value);
                    if ($width !== $height) {
                        $fail('The logo must be a square image with dimensions exactly 150x150 pixels works best');
                    }
                },
            ],
        ];
    }
}
