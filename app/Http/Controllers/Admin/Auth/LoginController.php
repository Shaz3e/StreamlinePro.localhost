<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\String\b;

class LoginController extends Controller
{
    public function view()
    {
        return view('admin.auth.login');
    }

    public function post(LoginRequest $request)
    {
        // Validate request
        $validated = $request->validated();

        // Find admin
        $admin = Admin::where('email', $validated['email'])->first();

        // If admin not found or password is incorrect
        if (!$admin || !password_verify($validated['password'], $admin->password)) {
            session()->flash('error', 'The provided credentials do not match our records.');
            return back();
        }

        // if admin is not active
        if (!$admin->is_active) {
            session()->flash('error', 'Your account is deactivated. Please contact your administrator.');
            return back();
        }

        // Session regenrate
        session()->regenerate();
        
        // Authenticate and Login
        Auth::guard('admin')->login($admin);
        session()->flash('success', 'Welcome ' . $admin->name);
        return redirect()->route('admin.dashboard');
    }
}
