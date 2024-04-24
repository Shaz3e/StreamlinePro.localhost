<?php

namespace App\Http\Requests\Admin\TicketPriority;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreTicketPriorityReqeust extends BaseFormRequest
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
                Rule::unique('support_ticket_priorities', 'name')->ignore($this->ticket_priority),
            ],
            'text_color' => [
                'nullable', 'hex_or_alpha',
            ],
            'bg_color' => [
                'nullable', 'hex_or_alpha',
            ],
            'is_active' => [
                'required', 'boolean',
            ],
        ];
    }

    /**
     * Get the validation message that apply to the request.
     */
    public function messages()
    {
        return [
            'is_active.boolean' => 'Status is not valid',
        ];
    }
}
