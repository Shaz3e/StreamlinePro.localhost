<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function view()
    {
        return view('user.auth.login');
    }

    public function post(LoginRequest $request)
    {
        // Validate request
        $validated = $request->validated();

        // Find user
        $user = User::where('email', $validated['email'])->first();

        // If user not found or password is incorrect
        if (!$user || !password_verify($validated['password'], $user->password)) {
            session()->flash('error', 'The provided credentials do not match our records.');
            return back();
        }

        // if user is not active
        if (!$user->is_active) {
            session()->flash('error', 'Your account is deactivated. Please contact your administrator.');
            return back();
        }

        // Session regenrate
        session()->regenerate();
        
        // Authenticate and Login
        Auth::login($user);
        session()->flash('success', 'Welcome ' . $user->name);
        return back();
        return redirect()->route('dashboard');
    }
}
