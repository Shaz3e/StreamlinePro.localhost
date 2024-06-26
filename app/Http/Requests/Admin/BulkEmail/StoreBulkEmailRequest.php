<?php

namespace App\Http\Requests\Admin\BulkEmail;

use App\Http\Requests\BaseFormRequest;
use Carbon\Carbon;

class StoreBulkEmailRequest extends BaseFormRequest
{
    /**
     * mutatorReminder
     *
     * @param  mixed $value
     * @return void
     */
    public function mutatorSendDate($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * prepareForValidation
     *
     * @return void
     */
    public function prepareForValidation()
    {
        if ($this->send_date) {
            $this->merge([
                'send_date' => Carbon::parse($this->send_date)->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'user_id' => 'required_if:send_to,user',
            'admin_id' => 'required_if:send_to,staff',
            'send_date' => [
                'nullable',
                'date_format:"Y-m-d H:i:s"',
                'after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
            'is_publish' => 'required|boolean'
        ];
    }
}
