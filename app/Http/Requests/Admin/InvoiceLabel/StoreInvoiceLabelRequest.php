<?php

namespace App\Http\Requests\Admin\InvoiceLabel;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceLabelRequest extends BaseFormRequest
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
                Rule::unique('invoice_labels', 'name')->ignore($this->invoice_label),
            ],
            'description' => [
                'nullable', 'string', 'max:255',
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
