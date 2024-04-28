<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\StoreProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $staff = Auth::user();

        return view('admin.profile.profile', [
            'staff' => $staff,
        ]);
    }

    /**
     * Update profile
     *
     * @param  mixed $request
     * @return void
     */
    public function profileStore(StoreProfileRequest $request)
    {
        if ($request->has('updatePassword')) {
            return $this->updatePassword($request);
        }

        if ($request->has('updateProfile')) {
            return $this->updateProfile($request);
        }

        return back();
    }

    private function updateProfile(Request $request)
    {
        // validated data
        $validated = $request->validated();

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
        // validate data
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|max:64',
            'confirm_password' => 'required|same:password'
        ]);

        // Get current user
        $user = Auth::user();

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

        $user->password = $validated['password'];
        $user->save();

        session()->flash('success', 'Your password has been changed');
        return back();
    }
}
