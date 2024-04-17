<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;

class StoreUserRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => 'required|string|min:8|max:255',
            'confirm_password' => 'required|same:password',
            'is_active' => 'required|boolean',
        ];
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
