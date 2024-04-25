<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketPriority\StoreTicketPriorityReqeust;
use App\Models\SupportTicketPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class TicketPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', SupportTicketPriority::class);

        return view('admin.ticket-priority.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', SupportTicketPriority::class);

        return view('admin.ticket-priority.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketPriorityReqeust $request)
    {
        // Check Authorize
        Gate::authorize('create', SupportTicketPriority::class);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        SupportTicketPriority::create($validated);

        session()->flash('success', 'Ticket Priority has been created successfully!');

        return redirect()->route('admin.ticket-priority.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicketPriority $ticketPriority)
    {
        // Check Authorize
        Gate::authorize('view', $ticketPriority);

        $audits = $ticketPriority->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.ticket-priority.show', [
            'ticketPriority' => $ticketPriority,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicketPriority $ticketPriority)
    {
        // Check Authorize
        Gate::authorize('update', $ticketPriority);

        return view('admin.ticket-priority.edit', [
            'ticketPriority' => $ticketPriority,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTicketPriorityReqeust $request, SupportTicketPriority $ticketPriority)
    {
        // Check Authorize
        Gate::authorize('update', $ticketPriority);

        // Validate data
        $validated = $request->validated();

        // Update record in database
        $ticketPriority->update($validated);

        // Flash message
        session()->flash('success', 'Ticket Priority has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.ticket-priority.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', SupportTicketPriority::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.ticket-priority.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.ticket-priority.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {        
        // Check Authorize
        Gate::authorize('delete', SupportTicketPriority::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.todo-status.index');
    }
}
