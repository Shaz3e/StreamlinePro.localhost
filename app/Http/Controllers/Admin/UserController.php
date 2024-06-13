<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Jobs\User\SendUserRegistrationEmailJob;
use App\Models\Company;
use App\Models\User;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class UserController extends Controller
{
    use FormHelper;

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

        return view('admin.user.create');
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
        $user = User::create($validated);
        $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
        $user->save();

        // Only Dispatch a job to send user registration email if uer can login is enabled
        if ($user->is_active) {
            SendUserRegistrationEmailJob::dispatch($user);
        }

        session()->flash('success', 'User created successfully!');

        return $this->saveAndRedirect($request, 'users', $user->id);
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
        $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
        $user->save();

        // Send password to user
        

        // Flash message
        session()->flash('success', 'User updated successfully!');

        return $this->saveAndRedirect($request, 'users', $user->id);
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

    /**
     * Search Users
     */
    public function searchUsers(Request $request)
    {
        // Check Authorize
        Gate::authorize('create', User::class);

        $term = $request->input('term');
        $users = User::where('name', 'like', '%' . $term . '%')
            ->orWhere('email', 'like', '%' . $term . '%')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'results' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->name
                ];
            })
        ]);
    }
}
