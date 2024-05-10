<?php

namespace App\Providers;

use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            // return $user->hasRole('superadmin') ? true : null;
            return $user->hasAnyRole(['superadmin', 'developer']) ? true : null;
        });

        /**
         * Hex or Alpha Validation rule
         */
        Validator::extend('hex_or_alpha', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$|^[a-zA-Z]+$/', $value);
        });

        /**
         * validate each item in array when uploading image(s)
         */
        Validator::extend('validate_each', function ($attribute, $value, $parameters, $validator) {
            foreach ($value as $file) {
                if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png'])) {
                    return false;
                }
            }
            return true;
        });
    }
}
