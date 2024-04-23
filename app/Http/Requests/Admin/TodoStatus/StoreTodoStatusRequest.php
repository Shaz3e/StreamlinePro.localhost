<?php

namespace App\Http\Requests\Admin\TodoStatus;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreTodoStatusRequest extends BaseFormRequest
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
                Rule::unique('todo_statuses', 'name')->ignore($this->todo_status),
            ],
            'is_active' => [
                'required', 'boolean',
            ],
        ];
    }

    /**
     * Get the validation message that apply to the request.
     * messages
     *
     * @return void
     */
    public function messages()
    {
        return [
            'is_active.boolean' => 'User status is not valid',
        ];
    }
}
