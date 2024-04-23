<?php

namespace App\Http\Requests\Admin\Todo;

use App\Http\Requests\BaseFormRequest;
use Carbon\Carbon;

class StoreTodoRequest extends BaseFormRequest
{
    /**
     * mutatorReminder
     *
     * @param  mixed $value
     * @return void
     */
    public function mutatorReminder($value)
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
        if ($this->reminder) {
            $this->merge([
                'reminder' => Carbon::parse($this->reminder)->format('Y-m-d H:i:s'),
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
            'todo_details' => [
                'required'
            ],
            'todo_status_id' => [
                'required', 'integer', 'exists:todo_statuses,id'
            ],
            'reminder' => [
                'nullable',
                'date_format:"Y-m-d H:i:s"',
                'after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
