<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketStatus\StoreTicketStatusRequest;
use App\Models\SupportTicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TicketStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('ticket-status.list');

        return view('admin.ticket-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('ticket-status.create');

        return view('admin.ticket-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketStatusRequest $request)
    {
        // Check Authorize
        Gate::authorize('ticket-status.create');

        // Validate data
        $validated = $request->validated();

        // Update record in database
        SupportTicketStatus::create($validated);

        session()->flash('success', 'Ticket Status has been created successfully!');

        return redirect()->route('admin.ticket-status.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicketStatus $ticketStatus)
    {
        // Check Authorize
        Gate::authorize('ticket-status.read');

        $audits = $ticketStatus->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.ticket-status.show', [
            'ticketStatus' => $ticketStatus,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicketStatus $ticketStatus)
    {
        // Check Authorize
        Gate::authorize('ticket-status.update');

        return view('admin.ticket-status.edit', [
            'ticketStatus' => $ticketStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTicketStatusRequest $request, SupportTicketStatus $ticketStatus)
    {
        // Check Authorize
        Gate::authorize('ticket-status.update');

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $ticketStatus->update($validated);

        // Flash message
        session()->flash('success', 'Ticket Status has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.ticket-status.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('ticket-status.read');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.ticket-status.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.ticket-status.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('ticket-status.delete');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todo-status.index');
    }
}
