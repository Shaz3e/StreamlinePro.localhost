<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\StoreLeadRequest;
use App\Models\Admin;
use App\Models\Lead;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeadController extends Controller
{
    use FormHelper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', Lead::class);

        return view('admin.lead.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', Lead::class);

        return view('admin.lead.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request)
    {
        // Check Authorize
        Gate::authorize('create', Lead::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $lead = Lead::create($validated);

        session()->flash('success', 'Lead created successfully!');

        return $this->saveAndRedirect($request, 'leads', $lead->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        // Check Authorize
        Gate::authorize('view', $lead);

        $staffList = Admin::where('is_active', true)->get();

        // Check for duplicates by email or phone
        $duplicates = Lead::where(function ($query) use ($lead) {
            $query->where('email', $lead->email)
                ->orWhere('phone', $lead->phone);
        })->where('id', '!=', $lead->id) // Exclude the current lead
            ->count();

        return view('admin.lead.show', [
            'lead' => $lead,
            'staffList' => $staffList,
            'duplicates' => $duplicates,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        // Check Authorize
        Gate::authorize('update', $lead);

        $staffList = Admin::where('is_active', true)->get();

        return view('admin.lead.edit', [
            'lead' => $lead,
            'staffList' => $staffList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLeadRequest $request, Lead $lead)
    {
        // Check Authorize
        Gate::authorize('update', $lead);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $lead->update($validated);

        // Flash message
        session()->flash('success', 'Lead updated successfully!');

        return $this->saveAndRedirect($request, 'leads', $lead->id);
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        // Check Authorize
        Gate::authorize('update', $lead);

        // Validate data
        $validated = $request->validate([
            'status' => 'required|string|max:50',
            'created_by' => 'required|exists:admins,id',
            'updated_by' => 'required|exists:admins,id',
            'assigned_by' => 'required|exists:admins,id',
            'assigned_to' => 'required|exists:admins,id',
        ]);

        // Update record in database
        $lead->update($validated);

        // Flash message
        session()->flash('success', 'Lead updated successfully!');

        return redirect()->route('admin.leads.show', $lead);
    }
}
