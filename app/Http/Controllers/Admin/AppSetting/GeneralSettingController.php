<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class GeneralSettingController extends Controller
{
    public function general()
    {
        // Check authorize
        Gate::authorize('general', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function generalStore(Request $request)
    {
        // Check authorize
        Gate::authorize('generalStore', AppSetting::class);

        // Define validation rules for the request
        $rules = [
            'site_name' => 'required|string|max:255',
            'site_url' => 'required|url|max:255',
            'app_url' => 'required|url|max:255',
            'site_logo_light' => 'nullable|mimes:jpeg,png|max:2048',
            'site_logo_dark' => 'nullable|mimes:jpeg,png|max:2048',
            'site_logo_small' => 'nullable|mimes:jpeg,png|max:2048',
            'site_timezone' => 'required',
        ];

        // Validate the request data based on the rules
        $validated = $request->validate($rules);

        // Upload Logo
        if ($request->hasFile('site_logo_light')) {
            $filename = time() . '-light.' . $request->file('site_logo_light')->extension();
            $path = $request->file('site_logo_light')->storeAs('settings/logo', $filename, 'public');
            $validated['site_logo_light'] = $path; // Store the path in the $validated array
        }
        if ($request->hasFile('site_logo_dark')) {
            $filename = time() . '-dark.' . $request->file('site_logo_dark')->extension();
            $path = $request->file('site_logo_dark')->storeAs('settings/logo', $filename, 'public');
            $validated['site_logo_dark'] = $path; // Store the path in the $validated array
        }
        if ($request->hasFile('site_logo_small')) {
            $filename = time() . '-small.' . $request->file('site_logo_small')->extension();
            $path = $request->file('site_logo_small')->storeAs('settings/logo', $filename, 'public');
            $validated['site_logo_small'] = $path; // Store the path in the $validated array
        }

        // Loop through each validated field and update or create the settings
        foreach ($validated as $key => $value) {
            AppSetting::updateOrCreate(
                ['name' => $key],
                ['value' => $value]
            );
        }

        $envPath = base_path('.env');
        $envContent = File::get($envPath);
        
        $envData = [
            'APP_NAME' => "\"{$validated['site_name']}\"",
            'APP_URL' => rtrim($validated['app_url'], '/'),
            'APP_TIMEZONE' => $validated['site_timezone'],
        ];

        // Update the key-value pairs
        foreach ($envData as $key => $value) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        }

        File::put($envPath, $envContent);
        Artisan::call('optimize:clear');

        Auth::guard('admin')->login(auth()->user());

        return back()->with('success', 'Setting Saved');
    }
}
