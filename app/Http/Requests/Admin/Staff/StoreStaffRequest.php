<?php

namespace App\Http\Requests\Admin\Staff;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends BaseFormRequest
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
                Rule::unique('admins', 'email')->ignore($this->staff),
            ],
            'department_id' => [
                'nullable',
                'array',
                Rule::exists('companies', 'id'),
            ],
            'mobile' => [
                'nullable',
                'string',
                'min:12',
                'max:20',
                Rule::unique('admins', 'mobile')->ignore($this->staff),
            ],
            'roles' => [
                'required',
                'array',
                Rule::exists('roles', 'name'),
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
}
