<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $admin = Auth::guard('admin')->user();
        $user = Auth::user();

        if ($admin) {
            return $admin->id;
        } else if ($user) {
            return $user->id;
        }else{
            return true;
        }
    }
}
