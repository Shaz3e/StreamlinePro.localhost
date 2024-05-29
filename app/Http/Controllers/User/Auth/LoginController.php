<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function view(Request $request)
    {

        // Check for temp token coming from user registration email
        if($request->has('token')) {
            // check token
            $user = User::where('remember_token', $request->token)->first();

            // if user does not exists
            if(!$user){
                session()->flash('error', 'The provided credentials do not match our records.');
                return redirect()->route('login');
            }

            // if user can login
            if(!$user->is_active){
                session()->flash('error', 'Your account is deactivated. Please contact your administrator.');
                return redirect()->route('login');
            }

            // store token in session
            session()->put('token', $request->token);

            // session regenerate
            session()->regenerate();

            // login user
            Auth::login($user);
            session()->flash('success', 'Welcome ' . ucwords($user->name));
            
            // if token exists in session redirect to change password route            
            return redirect()->route('profile');
        }

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
        session()->flash('success', 'Welcome ' . ucwords($user->name));
        return redirect()->route('dashboard');
    }
}
