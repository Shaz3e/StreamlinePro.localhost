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
            return $user->hasRole('superadmin') ? true : null;
        });

        /**
         * Hex or Alpha Validation rule
         */
        Validator::extend('hex_or_alpha', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$|^[a-zA-Z]+$/', $value);
        });
    }
}
