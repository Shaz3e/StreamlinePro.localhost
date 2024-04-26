<?php

namespace App\Http\Requests\Admin\TicketStatus;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreTicketStatusRequest extends BaseFormRequest
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
                Rule::unique('support_ticket_statuses', 'name')->ignore($this->ticket_status),
            ],
            'slug' => [
                'nullable',
                Rule::unique('support_ticket_statuses', 'slug')->ignore($this->ticket_status),
            ],
            'description' => [
                'nullable', 'string',
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
}
