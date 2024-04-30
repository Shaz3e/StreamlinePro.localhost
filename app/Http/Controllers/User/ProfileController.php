<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        return view('user.profile.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update profile
     *
     * @param  mixed $request
     * @return void
     */
    public function profileStore(Request $request)
    {
        if ($request->has('updatePassword')) {
            return $this->updatePassword($request);
        }

        if ($request->has('updateProfile')) {
            return $this->updateProfile($request);
        }
    }

    private function updateProfile(Request $request)
    {
        // validated data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . Auth::user()->id,
        ]);

        // Get current user
        $user = Auth::user();
        $user->update($validated);

        session()->flash('success', 'Profile updated successfully!');

        return back();
    }

    /**
     * Change password
     *
     * @param  mixed $request
     * @return void
     */
    private function updatePassword(Request $request)
    {
        // validate data and check if token session exists
        if (session()->has('token')) {
            $validated = $this->validatePassword($request, false);
        } else {
            $validated = $this->validatePassword($request);
        }

        // Get current user
        $user = Auth::user();

        // If token session exists
        if(!session()->has('token')){
            // If current password is incorrect
            if (!password_verify($validated['current_password'], $user->password)) {
                session()->flash('error', 'Your current password is incorrect.');
                return back();
            }
            // If new password is same as old password
            if (password_verify($validated['password'], $user->password)) {
                session()->flash('error', 'Your new password should not be same as your old password.');
                return back();
            }
        }

        // clear temporarly token session
        session()->forget('token');

        $user->password = $validated['password'];
        $user->save();

        session()->flash('success', 'Your password has been changed');
        return back();
    }


    /**
     * validatePassword
     *
     * @param  mixed $request
     * @param  mixed $requireCurrentPassword
     * @return void
     */
    private function validatePassword(Request $request, $requireCurrentPassword = true)
    {
        $rules = [
            'password' => 'required|min:8|max:64',
            'confirm_password' => 'required|same:password'
        ];

        if ($requireCurrentPassword) {
            $rules['current_password'] = 'required';
        }

        return $request->validate($rules);
    }
}
