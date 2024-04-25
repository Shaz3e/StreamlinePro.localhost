<?php

namespace App\Http\Requests\Admin\Task;

use App\Http\Requests\BaseFormRequest;
use Carbon\Carbon;

class StoreTaskRequest extends BaseFormRequest
{
    /**
     * mutatorReminder
     *
     * @param  mixed $value
     * @return void
     */
    public function mutatorDueDate($value)
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
        if ($this->due_date) {
            $this->merge([
                'due_date' => Carbon::parse($this->due_date)->format('Y-m-d H:i:s'),
            ]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required', 'string', 'max:255',
            ],
            'description' => [
                'required'
            ],
            'task_status_id' => [
                'required', 'integer', 'exists:task_statuses,id'
            ],
            'assigned_to' => [
                'required', 'integer', 'exists:admins,id'
            ],
            'due_date' => [
                'after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
            'start_date' => [
                'nullable',
                'date_format:"Y-m-d H:i:s"',
                'after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
            'due_date' => [
                'nullable',
                'date_format:"Y-m-d H:i:s"',
                'after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
