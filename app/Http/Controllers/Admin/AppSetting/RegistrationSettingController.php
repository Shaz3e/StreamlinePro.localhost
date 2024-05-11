<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RegistrationSettingController extends Controller
{
    public function registration()
    {
        // Check authorize
        Gate::authorize('registration', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function registrationStore(Request $request)
    {
        // Check authorize
        Gate::authorize('registrationStore', AppSetting::class);

        // Define validation rules for the request
        $rules = [
            'can_customer_register' => 'required|boolean',
            'can_user_reset_password' => 'required|boolean',
            'can_admin_register' => 'required|boolean',
            'can_admin_reset_password' => 'required|boolean',
        ];

        // Validate the request data based on the rules
        $validated = $request->validate($rules);

        // Loop through each validated field and update or create the settings
        foreach ($validated as $key => $value) {
            AppSetting::updateOrCreate(
                ['name' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Setting Saved');
    }
}
