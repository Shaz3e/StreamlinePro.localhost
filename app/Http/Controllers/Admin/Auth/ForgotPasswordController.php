<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;
use App\Mail\Admin\Auth\ForgotPassword;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function view()
    {
        return view('admin.auth.forgot-password');
    }

    public function post(ForgotPasswordRequest $request)
    {
        // Validate request
        $request->validated();

        // Get admin data
        $admin = Admin::where('email', $request->email)->first();

        // Generate random code with Str
        $token = Str::random(60);

        // Insert Token
        DB::table('password_reset_tokens')->insert([
            'email' => $admin->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Prepair mail data
        $mailData = [
            'name' => $admin->name,
            'email' => $admin->email,
            'token' => $token,
            'url' => config('app.url') . '/admin/reset/' . $admin->email . '/' . $token,
        ];

        // Send email to admin
        Mail::to($admin->email)->send(new ForgotPassword($mailData));

        // flash message
        session()->flash('success', 'We have e-mailed you password reset link!');

        // redirect
        return redirect()->route('admin.login');
    }
}
