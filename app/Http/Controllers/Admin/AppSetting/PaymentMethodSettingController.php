<?php

namespace App\Http\Controllers\Admin\AppSetting;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PaymentMethodSettingController extends Controller
{
    public function paymentMethod()
    {
        // Check authorize
        Gate::authorize('paymentMethod', AppSetting::class);

        return view('admin.app-setting.main');
    }

    public function paymentMethodStore(Request $request)
    {
        // Check authorize
        Gate::authorize('paymentMethodStore', AppSetting::class);

        // Stripe
        if ($request->has('stripePaymentMethod')) {
            // Validate the request data based on the rules
            $validated = $request->validate([
                'stripe' => 'required|boolean',
                'stripe_display_name' => 'required|max:255',
                'stripe_hosted_checkout' => 'required|boolean',
                'stripe_hosted_checkout_display_name' => 'required|max:255',
                'stripe_key' => 'required|string|max:255',
                'stripe_secret' => 'required|string|max:255',
            ]);

            // Update or create the setting in the database
            AppSetting::updateOrCreate(
                ['name' => 'stripe'],
                ['value' => $validated['stripe']]
            );
            AppSetting::updateOrCreate(
                ['name' => 'stripe_display_name'],
                ['value' => $validated['stripe_display_name']]
            );
            AppSetting::updateOrCreate(
                ['name' => 'stripe_hosted_checkout'],
                ['value' => $validated['stripe_hosted_checkout']]
            );
            AppSetting::updateOrCreate(
                ['name' => 'stripe_hosted_checkout_display_name'],
                ['value' => $validated['stripe_hosted_checkout_display_name']]
            );

            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            $envData = [
                'STRIPE_KEY' => $validated['stripe_key'],
                'STRIPE_SECRET' => $validated['stripe_secret'],
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
        }

        Artisan::call('optimize:clear');

        return back()->with('success', 'Setting Saved');
    }
}
