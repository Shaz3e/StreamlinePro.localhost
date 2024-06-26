<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkEmail\StoreBulkEmailRequest;
use App\Models\BulkEmail;
use App\Trait\Admin\FormHelper;
use Illuminate\Support\Facades\Gate;

class BulkEmailController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', BulkEmail::class);

        return view('admin.email-management.bulk-email.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', BulkEmail::class);

        return view('admin.email-management.bulk-email.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBulkEmailRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', BulkEmail::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $bulkEmail = BulkEmail::create($validated);

        session()->flash('success', 'Email has been created successfully!');

        return $this->saveAndRedirect($request, 'email-management.bulk-emails', $bulkEmail->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(BulkEmail $bulkEmail)
    {
        // Check Authorize
        Gate::authorize('view', $bulkEmail);

        return view('admin.email-managment.bulk-email.show', [
            'bulkEmail' => $bulkEmail,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BulkEmail $bulkEmail)
    {
        // Check Authorize
        Gate::authorize('update', $bulkEmail);

        // stop editing if email has been sent
        if ($bulkEmail->is_sent) {
            session()->flash('error', 'You cannot edit a sent email!');
            return redirect()->back();
        }

        return view('admin.email-management.bulk-email.edit', [
            'bulkEmail' => $bulkEmail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBulkEmailRequest $request, BulkEmail $bulkEmail)
    {
        // Check Authorize
        Gate::authorize('update', $bulkEmail);

        // stop editing if email has been sent
        if ($bulkEmail->is_sent) {
            session()->flash('error', 'You cannot edit a sent email!');
            return redirect()->back();
        }

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $bulkEmail->update($validated);

        // Flash message
        session()->flash('success', 'Email has been updated successfully!');

        return $this->saveAndRedirect($request, 'email-management.bulk-emails', $bulkEmail->id);
    }

}
