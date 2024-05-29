<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;
use App\Mail\User\Auth\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function view()
    {
        return view('user.auth.forgot-password');
    }

    public function post(ForgotPasswordRequest $request)
    {
        // Validate request
        $request->validated();

        // Get user data
        $user = User::where('email', $request->email)->first();

        // Generate random code with Str
        $token = Str::random(60);

        // Insert Token
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Prepair mail data
        $mailData = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'url' => config('app.url') . '/reset/' . $user->email . '/' . $token,
        ];

        // Send email to user
        Mail::to($user->email)->send(new ForgotPassword($mailData));

        // flash message
        session()->flash('success', 'We have e-mailed you password reset link!');

        // redirect
        return redirect()->route('login');
    }
}
