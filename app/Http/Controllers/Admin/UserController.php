<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Restore the specified resource from storage.
     */
    // public function restore(Request $request)
    // public function restore(User $user)
    // {
    //     //
    // }

    /**
     * Permanent Remove the specified resource from storage.
     */
    // public function forceDelete(Request $request)
    // public function forceDelete(User $user)
    // {
    //     //
    // }

    /**
     * Show Audit Log
     */
    // public function audit(Request $request)
    // {
    //     if (request()->ajax()) {
    //         $auditLog = Audit::find($request->id);

    //         return view('admin.user.audit', [
    //             'auditLog' => $auditLog,
    //         ]);
    //     } else {
    //         session()->flash('error', 'Log not available');
    //         return redirect()->route('admin.users');
    //     }
    // }
}
