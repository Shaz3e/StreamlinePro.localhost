<?php

namespace App\Http\Requests\Admin\Lead;

use App\Http\Requests\BaseFormRequest;

class StoreLeadRequest extends BaseFormRequest
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
                'required',
                'string',
                'max:255',
            ],
            'company' => [
                'required',
                'string',
                'max:255',
            ],
            'country' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'product' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'nullable',
            ],
            'status' => [
                'required',
                'string',
            ],
        ];
    }
}
