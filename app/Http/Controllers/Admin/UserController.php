<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Mail\Admin\User\PasswordReset;
use App\Models\Admin;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Models\Audit;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', User::class);

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', User::class);
        
        $companies = Company::where('is_active', 1)->get();

        return view('admin.user.create', [
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', User::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        User::create($validated);

        session()->flash('success', 'User created successfully!');

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Check Authorize
        Gate::authorize('view', $user);

        $audits = $user->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.user.show', [
            'user' => $user,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Check Authorize
        Gate::authorize('update', $user);

        $companies = Company::where('is_active', 1)->get();

        return view('admin.user.edit', [
            'user' => $user,
            'companies' => $companies,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, User $user)
    {
        // Check Authorize
        Gate::authorize('update', $user);

        // Validate data
        $validated = $request->validated();

        // Check if pasword is filled
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Update record in database
        $user->update($validated);

        // Send password to user
        if ($request->filled('password')) {
            $mailData = [
                'url' => config('app.url'),
                'name' => $user->name,
                'email' => $user->email,
                'password' => $request->password,
            ];

            Mail::to($mailData['email'])->send(new PasswordReset($mailData));
        }

        // Flash message
        session()->flash('success', 'User updated successfully!');

        // Redirect to index
        return redirect()->route('admin.users.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', User::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.user.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('delete', User::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.users.index');
    }
}
