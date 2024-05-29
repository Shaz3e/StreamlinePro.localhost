<?php

namespace App\Http\Requests\Admin\Promotion;

use App\Http\Requests\BaseFormRequest;
use Carbon\Carbon;

class StorePromotionRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'start_date' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $date = date('Y-m-d', strtotime($value));
                    request()->merge([$attribute => $date]);
                },
            ],
            'end_date' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $date = date('Y-m-d', strtotime($value));
                    request()->merge([$attribute => $date]);
                },
            ],
        ];

        if ($this->method() === 'POST') {
            $rules = array_merge($rules, [
                'image' => [
                    'required', 'image', 'max:5120',
                ],
            ]);
        } else {
            $rules = array_merge($rules, [
                'image' => [
                    'nullable', 'image', 'max:5120',
                ],
            ]);
        }
        return $rules;
    }
}
