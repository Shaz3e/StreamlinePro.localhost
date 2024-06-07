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

        if ($request->has('stripePaymentMethod')) {
            $this->stripe($request);
        }

        if ($request->has('ngeniusNetworkPaymentMethod')) {
            $this->ngeniusNetwork($request);
        }

        return back()->with('success', 'Setting Saved');
    }

    /**
     * Stripe Setting Store
     */
    private function stripe(Request $request)
    {
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

        Artisan::call('optimize:clear');
    }

    /**
     * nGenius Network Setting Store
     */
    public function nGeniusNetwork(Request $request)
    {

        // Validate the request data based on the rules
        $validated = $request->validate([
            'ngenius' => 'required|boolean',
            'ngenius_display_name' => 'required|max:255',
            'ngenius_hosted_checkout' => 'required|boolean',
            'ngenius_hosted_checkout_display_name' => 'required|max:255',
            'ngenius_api_key' => 'required|string|max:255',
            'ngenius_outlet' => 'required|string|max:255',
            'ngenius_domain' => 'required|url|max:255',
            'ngenius_environment' => 'required|in:live,sandbox',
            'ngenius_slim_mode' => 'required|in:1,2,true,false',
        ]);

        // Update or create the setting in the database
        AppSetting::updateOrCreate(
            ['name' => 'ngenius'],
            ['value' => $validated['ngenius']]
        );
        AppSetting::updateOrCreate(
            ['name' => 'ngenius_display_name'],
            ['value' => $validated['ngenius_display_name']]
        );
        AppSetting::updateOrCreate(
            ['name' => 'ngenius_hosted_checkout'],
            ['value' => $validated['ngenius_hosted_checkout']]
        );
        AppSetting::updateOrCreate(
            ['name' => 'ngenius_hosted_checkout_display_name'],
            ['value' => $validated['ngenius_hosted_checkout_display_name']]
        );

        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        $envData = [
            'NGENIUS_APIKEY' => $validated['ngenius_api_key'],
            'NGENIUS_OUTLET' => $validated['ngenius_outlet'],
            'NGENIUS_DOMAIN' => $validated['ngenius_domain'],
            'NGENIUS_ENVIRONMENT' => $validated['ngenius_environment'],
            'NGENIUS_SLIM_MODE' => $validated['ngenius_slim_mode'],
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
    }
}
