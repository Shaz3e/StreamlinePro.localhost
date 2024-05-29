<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\BaseFormRequest;

class ResetPasswordRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|min:8|max:255|string',
            'confirm_password' => 'required|min:8|max:255|string|same:password',
        ];
    }
}
