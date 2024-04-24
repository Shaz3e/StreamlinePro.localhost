<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupportTicket\StoreSupportTicketRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\SupportTicket;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('support-ticket.list');

        return view('admin.support-ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('support-ticket.create');

        // Get all active Staff/Admin
        $staffList = Admin::where('is_active', 1)->get();

        // Get all active Clients
        $clients = User::where('is_active', 1)->get();

        // Get all active Department
        $departments = Department::where('is_active', 1)->get();

        // Get all active suport ticket statuses
        $ticketStatuses = SupportTicketStatus::where('is_active', 1)->get();

        // Get all active suport ticket priority
        $ticketPriorities = SupportTicketPriority::where('is_active', 1)->get();

        return view('admin.support-ticket.create', [
            'staffList' => $staffList,
            'clients' => $clients,
            'departments' => $departments,
            'ticketStatuses' => $ticketStatuses,
            'ticketPriorities' => $ticketPriorities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupportTicketRequest $request)
    {
        // Check Authorize
        Gate::authorize('support-ticket.create');

        // Validate data
        $validated = $request->validated();

        // Generate a Ticket Number
        $ticketNumber = 'TKT-' . time() . '-' . date('d-m-y');

        // Provide a ticket number as generated above
        $validated['ticket_number'] = $ticketNumber;

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $filename = $ticketNumber . '.' . $file->extension();
                $attachments[] = $file->storeAs('support-tickets/attachments', $filename, 'public');
            }
            $validated['attachments'] = json_encode($attachments); // Serialize the array to a JSON string
        }

        // Update record in database
        SupportTicket::create($validated);

        session()->flash('success', 'Support Ticket has been created successfully!');

        return redirect()->route('admin.support-tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        // Check Authorize
        Gate::authorize('support-ticket.read');

        $audits = $supportTicket->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.support-ticket.show', [
            'supportTicket' => $supportTicket,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicket $supportTicket)
    {
        // Check Authorize
        Gate::authorize('support-ticket.update');

        // Get all active Staff/Admin
        $staffList = Admin::where('is_active', 1)->get();

        // Get all active Clients
        $clients = User::where('is_active', 1)->get();

        // Get all active Department
        $departments = Department::where('is_active', 1)->get();

        // Get all active suport ticket statuses
        $ticketStatuses = SupportTicketStatus::where('is_active', 1)->get();

        // Get all active suport ticket priority
        $ticketPriorities = SupportTicketPriority::where('is_active', 1)->get();

        return view('admin.support-ticket.edit', [
            'supportTicket' => $supportTicket,
            'staffList' => $staffList,
            'clients' => $clients,
            'departments' => $departments,
            'ticketStatuses' => $ticketStatuses,
            'ticketPriorities' => $ticketPriorities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSupportTicketRequest $request, SupportTicket $supportTicket)
    {
        // Check Authorize
        Gate::authorize('support-ticket.update');

        // Validate data
        $validated = $request->validated();

        // Generate a Ticket Number
        
        if ($request->hasFile('attachments')) {
            $ticketNumber = $supportTicket->ticket_number;
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $filename = $ticketNumber . '.' . $file->extension();
                $attachments[] = $file->storeAs('support-tickets/attachments', $filename, 'public');
            }
            $validated['attachments'] = json_encode($attachments); // Serialize the array to a JSON string
        }

        // Update record in database
        $supportTicket->update($validated);

        // Flash message
        session()->flash('success', 'Todo Status has been updated successfully!');

        // Redirect to index
        return redirect()->route('admin.support-tickets.index');
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('support-ticket.read');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);

            return view('admin.support-ticket.audit', [
                'auditLog' => $auditLog,
            ]);
        } else {
            session()->flash('error', 'Log not available');
            return redirect()->route('admin.support-tickets.index');
        }
    }

    /**
     * Delete Audit Log
     */
    public function deleteAudit(Request $request)
    {
        // Check Authorize
        Gate::authorize('support-ticket.delete');

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.support-tickets.index');
    }
}
