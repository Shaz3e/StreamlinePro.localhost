<?php

namespace App\Http\Requests\Admin\Todo;

use App\Http\Requests\BaseFormRequest;
use Carbon\Carbon;

class StoreTodoRequest extends BaseFormRequest
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
                'required', 'string', 'max:255',
            ],
            'todo_details' => [
                'required'
            ],
            'todo_label_id' => [
                'required', 'integer', 'exists:todo_labels,id'
            ],
            'reminder' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!strtotime($value)) {
                        return $fail(__('Invalid Invoice Date', [
                            'attribute' => $attribute,
                            'format' => 'Y-m-d',
                        ]));
                    } else {
                        $date = date('Y-m-d H:i:s', strtotime($value));
                        request()->merge([$attribute => $date]);
                    }
                },
                'after_or_equal:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
