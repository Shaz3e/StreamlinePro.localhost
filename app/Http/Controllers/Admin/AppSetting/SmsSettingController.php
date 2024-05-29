<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class SmsSettingController extends Controller
{
    public function sms()
    {
        // Check authorize
        Gate::authorize('sms', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function smsStore(Request $request)
    {
        // Check authorize
        Gate::authorize('smsStore', AppSetting::class);

        // Validate the request data based on the rules
        $validated = $request->validate([
            'twilio_sid' => 'required|max:255',
            'twilio_token' => 'required|max:255',
            'twilio_from' => 'required|max:255',
        ]);

        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $envData = [
            'TWILIO_SID' => $validated['twilio_sid'],
            'TWILIO_TOKEN' => $validated['twilio_token'],
            'TWILIO_FROM' => $validated['twilio_from'],
        ];

        // Update the key-value pairs in the .env content
        foreach ($envData as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                // If the key does not exist, add it
                $envContent .= "\n{$key}={$value}";
            }
        }

        File::put($envPath, $envContent);

        Artisan::call('optimize:clear');

        return back()->with('success', 'Setting Saved');
    }
}
