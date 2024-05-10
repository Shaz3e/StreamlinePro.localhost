<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\RegisterRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function view()
    {
        if(DiligentCreators('can_admin_register') == 0){
            return redirect()->route('admin.login');
        }
        
        return view('admin.auth.register');
    }

    public function post(RegisterRequest $request)
    {
        // Validate Request
        $validated = $request->validated();

        // Create User and Save to DB
        $user = new Admin();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        session()->flash('success', 'User created successfully!');

        return back();
    }
}
