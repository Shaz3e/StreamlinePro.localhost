<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectAdminIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        // Check if the admin is authenticated
        if (Auth::guard($guard)->check()) {
            // Check if the current route is a guest route
            if (
                $request->route()->getName() === 'admin.login' ||
                $request->route()->getName() === 'admin.register' ||
                $request->route()->getName() === 'admin.forgot.password' ||
                $request->route()->getName() === 'admin.password.reset'
            ) {
                // Redirect to the dashboard
                return redirect()->route('admin.dashboard');
            }
        }
        // Allow the request to proceed if the admin is not authenticated or no redirection is needed
        return $next($request);
    }
}
