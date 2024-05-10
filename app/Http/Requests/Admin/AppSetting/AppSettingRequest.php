<?php

namespace App\Http\Requests\Admin\AppSetting;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class AppSettingRequest extends BaseFormRequest
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
                'required', 'max:255',
                Rule::unique('app_settings', 'name')->ignore($this->app_setting),
            ],
            'value' => [
                'required', 'max:255'
            ],
        ];
    }
}
