<?php

namespace App\Http\Requests\Admin\Invoice;

use App\Http\Requests\BaseFormRequest;

class StoreInvoiceRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Invoices Table
            // Custom validation rule for `invoice_to` field
            'invoice_to' => ['required', function ($attribute, $value, $fail) {
                if ($value === 'user') {
                    // If `invoice_to` is 'user', `user_id` must be provided
                    if (empty($this->input('user_id'))) {
                        $fail('The user_id field is required when invoice_to is set to user.');
                    }
                } elseif ($value === 'company') {
                    // If `invoice_to` is 'company', `company_id` must be provided
                    if (empty($this->input('company_id'))) {
                        $fail('The company_id field is required when invoice_to is set to company.');
                    }
                }
            }],

            // Validate `user_id` and `company_id` based on the value of `invoice_to`
            'user_id' => ['sometimes', 'required_if:invoice_to,user', 'exists:users,id'],
            'company_id' => ['sometimes', 'required_if:invoice_to,company', 'exists:companies,id'],
            'invoice_lable_id' => ['required', 'exists:invoice_labels,id'],
            'invoice_date' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    // Allow null or empty values
                    if (empty($value)) {
                        return;
                    }

                    // Validate date format
                    if (!strtotime($value)) {
                        return $fail(__('Invalid Invoice Date', [
                            'attribute' => $attribute,
                            'format' => 'Y-m-d',
                        ]));
                    } else {
                        // Convert date format to Y-m-d
                        $date = date('Y-m-d', strtotime($value));
                        request()->merge([$attribute => $date]);
                    }
                },
            ],
            'due_date' => [
                'sometimes',
                'sometimes',
                function ($attribute, $value, $fail) {
                    // Allow null or empty values
                    if (empty($value)) {
                        return;
                    }

                    // Validate date format
                    if (!strtotime($value)) {
                        return $fail(__('Invalid Invoice Date', [
                            'attribute' => $attribute,
                            'format' => 'Y-m-d',
                        ]));
                    } else {
                        // Convert date format to Y-m-d
                        $date = date('Y-m-d', strtotime($value));
                        request()->merge([$attribute => $date]);
                    }
                },
            ],
            'status' => ['sometimes'],
            'is_published' => ['required', 'boolean'],
            'published_on' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    // Allow null or empty values
                    if (empty($value)) {
                        return;
                    }

                    // Validate date format
                    if (!strtotime($value)) {
                        return $fail(__('Invalid Invoice Date', [
                            'attribute' => $attribute,
                            'format' => 'Y-m-d',
                        ]));
                    } else {
                        // Convert date format to Y-m-d
                        $date = date('Y-m-d', strtotime($value));
                        request()->merge([$attribute => $date]);
                    }
                },
            ],
            'note' => ['sometimes'],
            'invoice_sub_total' => ['sometimes', 'decimal:0,12'],
            'invoice_total_discount' => ['sometimes', 'decimal:0,12'],
            'invoice_total_amount' => ['sometimes', 'decimal:0,12'],
            'invoice_total_paid' => ['sometimes', 'decimal:0,12'],

            // InvoiceItems Table
            'invoice_id' => ['required'],
            'item_description' => ['sometimes'],
            'quantity' => ['sometimes', 'integer'],
            'unit_price' => ['sometimes', 'decimal:0,12'],
            'sub_total' => ['sometimes', 'decimal:0,12'],
            'tax_value' => ['sometimes', 'decimal:0,12'],
            'discount_type' => ['sometimes', 'decimal:0,12'],
            'discount_value' => ['sometimes', 'decimal:0,12'],
            'total_price' => ['sometimes', 'decimal:0,12'],
        ];
    }
}
