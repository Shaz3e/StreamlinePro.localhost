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
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required', 'string', 'max:255',
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'name')->ignore($this->user),
            ],
            'company_id' => [
                'nullable',
                Rule::exists('companies', 'id'),
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
                'confirm_password' => [
                    'required', 'same:password',
                ],
            ]);
        } else {
            $rules = array_merge($rules, [
                'password' => [
                    'nullable', 'string', 'min:8', 'max:255',
                ],
                'confirm_password' => [
                    'nullable', 'same:password',
                ],
            ]);
        }

        return $rules;
    }

    /**
     * Get the validation message that apply to the request.
     */
    public function messages()
    {
        return [
            'is_active.boolean' => 'User status is not valid',
        ];
    }
}
