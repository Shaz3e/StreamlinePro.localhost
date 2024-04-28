<?php

namespace App\Http\Requests\Admin\Profile;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreProfileRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the current user's ID
        $userId = $this->user()->id;

        return [
            'name' => [
                'required', 'string', 'max:255',
            ],
            'email' => [
                'required', 'email',
                Rule::unique('admins', 'email')->ignore($userId),
            ],
        ];
    }
}
