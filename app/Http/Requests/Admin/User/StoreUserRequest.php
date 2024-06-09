<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseFormRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Validation\Rule;

class StoreUserRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     * @link https://laravel.com/docs/11.x/validation#available-validation-rules
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => [
                'required', 'string', 'max:20',
            ],
            'last_name' => [
                'required', 'string', 'max:20',
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'company_id' => [
                'nullable',
                Rule::exists('companies', 'id'),
            ],
            'phone' => [
                'nullable',
                'starts_with:+',
                'regex:/^\+[1-9]\d{1,14}$/',
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
            'country_id' => [
                'nullable',
                Rule::exists('countries', 'id'),
            ],
            'city' => [
                'nullable',
                'string',
                'max:50',
            ],
            'is_active' => [
                'required', 'boolean',
            ],
        ];

        if ($this->method() === 'POST') {
            $rules = array_merge($rules, [
                'password' => [
                    'required', 'string', 'min:8', 'max:255',
                ],
            ]);
        } else {
            $rules = array_merge($rules, [
                'password' => [
                    'nullable', 'string', 'min:8', 'max:255',
                ],
            ]);
        }

        return $rules;
    }
}
