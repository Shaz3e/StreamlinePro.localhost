<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function view()
    {
        return view('user.auth.reset-password');
    }

    public function post(ResetPasswordRequest $request)
    {
        // Check token
        $tokenExists = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->exists();

        if (!$tokenExists) {
            session()->flash('error', 'Password reset link is expired, please reset your password again.');
            return redirect()->route('forgot.password');
        }

        // When token and email are valid reset password
        // Get user data
        $user = User::where('email', $request->email)->first();

        // Change Password
        $user->password = bcrypt($request->password);
        $user->save();

        // Delete the token from database
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Success
        session()->flash('success', 'Password reset successfully. Please login with your new password.');
        
        // redirect to login page
        return redirect()->route('login');
    }
}
