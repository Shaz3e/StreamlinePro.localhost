<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CurrencySettingController extends Controller
{
    public function currency()
    {
        // Check authorize
        Gate::authorize('currency', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function currencyStore(Request $request)
    {
        // Check authorize
        Gate::authorize('currencyStore', AppSetting::class);

        $validated = $request->validate([
            'currency_id' => 'required|exists:currencies,id'
        ]);

        // Update or create the setting in the database
        AppSetting::updateOrCreate(
            ['name' => 'currency'],
            ['value' => $validated['currency_id']]
        );

        return back()->with('success', 'Setting Saved');
    }
}
