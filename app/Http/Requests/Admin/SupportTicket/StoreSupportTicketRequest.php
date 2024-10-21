<?php

namespace App\Http\Requests\Admin\SupportTicket;

use App\Http\Requests\BaseFormRequest;

class StoreSupportTicketRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
            ],
            'attachments' => [
                'nullable',
                'array',
            ],
            'attachments.*' => [ // This applies to each file in the attachments array
                'file',
                'mimes:jpeg,png,jpg,doc,docx,xls,xlsx,csv,pdf', // Allowed file types
                'max:51200', // Max file size in kilobytes (50MB)
            ],
            'is_internal' => [
                'boolean',
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'admin_id' => [
                'nullable',
                'integer',
                'exists:admins,id',
            ],
            'department_id' => [
                'nullable',
                'integer',
                'exists:departments,id',
            ],
            'support_ticket_status_id' => [
                'required',
                'integer',
                'exists:support_ticket_statuses,id',
            ],
            'support_ticket_priority_id' => [
                'required',
                'integer',
                'exists:support_ticket_priorities,id',
            ],
        ];
    }
}
