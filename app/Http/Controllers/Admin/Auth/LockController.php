<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockController extends Controller
{
    public function view()
    {
        $admin = request()->user();
        $admin->is_locked = true;
        $admin->save();

        return view('admin.auth.lock');
    }

    public function post(Request $request)
    {
        $admin = request()->user();

        // Validate request
        $validated = $request->validate([
            'password' => 'required|string|max:255|min:8',
        ]);

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

        // if admin is_locked = true change to false
        $admin->is_locked = false;
        $admin->save();

        // Session regenrate
        session()->regenerate();

        // Authenticate and Login
        Auth::guard('admin')->login($admin);
        session()->flash('success', 'Welcome Back ' . ucwords($admin->name));
        return redirect()->route('admin.dashboard');
    }
}
