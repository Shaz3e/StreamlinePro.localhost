<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockController extends Controller
{
    public function view()
    {
        return view('user.auth.lock');
    }

    public function post(Request $request)
    {
        $user = request()->user();

        // Validate request
        $validated = $request->validate([
            'password' => 'required|string|max:255|min:8',
        ]);

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
        session()->flash('success', 'Welcome Back ' . ucwords($user->name));

        return redirect()->route('dashboard');
    }
}
