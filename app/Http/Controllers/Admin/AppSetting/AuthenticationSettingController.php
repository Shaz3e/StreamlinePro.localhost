<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthenticationSettingController extends Controller
{
    public function authentication()
    {
        // Check authorize
        Gate::authorize('authentication', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function authenticationStore(Request $request)
    {
        // Check authorize
        Gate::authorize('authenticationStore', AppSetting::class);

        // Define validation rules for the request
        $rules = [
            'can_customer_register' => 'required|boolean',
            'can_user_reset_password' => 'required|boolean',
            'can_admin_register' => 'required|boolean',
            'can_admin_reset_password' => 'required|boolean',

            'login_page_heading' => 'nullable|string|max:255',
            'login_page_heading_color' => 'nullable|string|max:255',
            'login_page_heading_bg_color' => 'nullable|string|max:255',
            'login_page_text' => 'nullable|string|max:255',
            'login_page_text_color' => 'nullable|string|max:255',
            'login_page_text_bg_color' => 'nullable|string|max:255',
            'login_page_image' => 'nullable|mimes:jpeg,png|max:5120',

            'register_page_heading' => 'nullable|string|max:255',
            'register_page_heading_color' => 'nullable|string|max:255',
            'register_page_heading_bg_color' => 'nullable|string|max:255',
            'register_page_text' => 'nullable|string|max:255',
            'register_page_text_color' => 'nullable|string|max:255',
            'register_page_text_bg_color' => 'nullable|string|max:255',
            'register_page_image' => 'nullable|mimes:jpeg,png|max:5120',

            'reset_page_heading' => 'nullable|string|max:255',
            'reset_page_heading_color' => 'nullable|string|max:255',
            'reset_page_heading_bg_color' => 'nullable|string|max:255',
            'reset_page_text' => 'nullable|string|max:255',
            'reset_page_text_color' => 'nullable|string|max:255',
            'reset_page_text_bg_color' => 'nullable|string|max:255',
            'reset_page_image' => 'nullable|mimes:jpeg,png|max:5120',
        ];

        // Validate the request data based on the rules
        $validated = $request->validate($rules);

        // Upload login page image if provided
        if ($request->hasFile('login_page_image')) {
            $filename = time() . '-login-page.' . $request->file('login_page_image')->extension();
            $path = $request->file('login_page_image')->storeAs('settings/page', $filename, 'public');
            $validated['login_page_image'] = $path;
        }

        // Upload register page image if provided
        if ($request->has('register_page_image')) {
            $filename = time() . '-register-page.' . $request->file('register_page_image')->extension();
            $path = $request->file('register_page_image')->storeAs('settings/page', $filename, 'public');
            $validated['register_page_image'] = $path;
        }

        // Upload reset page image if provided
        if ($request->has('reset_page_image')) {
            $filename = time() . '-reset-page.' . $request->file('reset_page_image')->extension();
            $path = $request->file('reset_page_image')->storeAs('settings/page', $filename, 'public');
            $validated['reset_page_image'] = $path;
        }

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
