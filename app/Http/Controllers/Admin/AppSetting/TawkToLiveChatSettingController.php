<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TawkToLiveChatSettingController extends Controller
{
    public function tawkToChat()
    {

        // Check authorize
        Gate::authorize('tawkToChat', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function tawkToChatStore(Request $request)
    {
        // Check authorize
        Gate::authorize('tawkToChatStore', AppSetting::class);

        $validated = $request->validate([
            'tawk_to_property' => 'nullable|string|max:255',
            'tawk_to_widget' => 'nullable|string|max:255',
        ]);

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
