<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\StoreProfileRequest;
use App\Http\Requests\Common\Avatar\AvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function profileStore(Request $request)
    {
        if ($request->has('updatePassword')) {
            return $this->updatePassword($request);
        }

        if ($request->has('changeAvatar')) {
            return $this->changeAvatar($request);
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
            'email' => 'required|string|max:255|unique:admins,email,' . Auth::user()->id,
        ]);

        // Get current user
        $user = Auth::user();
        $user->update($validated);

        session()->flash('success', 'Profile updated successfully!');

        return back();
    }

    /**
     * Change Profile Avatar
     */
    private function changeAvatar(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:png,jpg|max:2048',
            'selected_avatar' => 'nullable|string'
        ]);

        $user = $request->user();

        // Check if a new avatar file has been uploaded
        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->extension();
            $validated['avatar'] = $request->file('avatar')
                ->storeAs('avatars', $filename, 'public');
            $user->avatar = $validated['avatar'];
        } elseif ($request->filled('selected_avatar')) {
            // If no file is uploaded, use the selected avatar path
            $user->avatar = $request->input('selected_avatar');
        }

        // Save the updated user data
        $user->save();

        // Flash a success message to the session
        session()->flash('success', 'Your profile picture is updated');

        // Redirect back to the previous page
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
