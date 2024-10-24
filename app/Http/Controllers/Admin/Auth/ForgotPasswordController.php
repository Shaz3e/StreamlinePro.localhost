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
        if(DiligentCreators('can_admin_reset_password') == 0){
            return redirect()->route('admin.login');
        }

        return view('admin.auth.forgot-password');
    }

    public function post(ForgotPasswordRequest $request)
    {
        // Validate request
        $validated = $request->validated();

        // Get admin data
        $admin = Admin::where('email', $request->email)->first();

        $tokenExists = DB::table('password_reset_tokens')->where('email', $validated['email'])->first();

        if ($tokenExists) {
            // Delete token
            DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();
        }

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
            'url' => config('app.url') . '/backoffice/reset/' . $admin->email . '/' . $token,
        ];

        // Send email to admin
        Mail::to($admin->email)->send(new ForgotPassword($mailData));

        // flash message
        session()->flash('success', 'We have e-mailed you password reset link!');

        // redirect
        return redirect()->route('admin.login');
    }
}
