<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupportTicket\StoreSupportTicketRequest;
use App\Models\SupportTicket;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketReply;
use App\Models\SupportTicketStatus;
use App\Trait\Admin\FormHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Models\Audit;

class SupportTicketController extends Controller
{
    use FormHelper;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Authorize
        Gate::authorize('viewAny', SupportTicket::class);

        return view('admin.support-ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check Authorize
        Gate::authorize('create', SupportTicket::class);

        // Get all active suport ticket statuses
        $ticketStatuses = SupportTicketStatus::where('is_active', 1)->get();

        // Get all active suport ticket priority
        $ticketPriorities = SupportTicketPriority::where('is_active', 1)->get();

        return view('admin.support-ticket.create', [
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
        Gate::authorize('create', SupportTicket::class);

        // Validate data
        $validated = $request->validated();

        // Generate a Ticket Number
        $ticketNumber = 'TKT-' . rand(1000, 9999) . time() . '-' . date('d-m-y');

        // Provide a ticket number as generated above
        $validated['ticket_number'] = $ticketNumber;

        // Retrieve all the uploaded images from the session variable
        $uploadedAttachments = session()->get('uploaded_attachments');

        if (!empty($uploadedAttachments)) {
            $validated['attachments'] = json_encode($uploadedAttachments);
        }

        // Update record in database
        $supportTicket = SupportTicket::create($validated);

        // Forget uploaded_attachments Session
        session()->forget('uploaded_attachments');

        session()->flash('success', 'Support Ticket has been created successfully!');

        return $this->saveAndRedirect($request, 'support-tickets', $supportTicket->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        // Check Authorize
        Gate::authorize('view', $supportTicket);

        // Get attachments
        // $attachments = json_decode($supportTicket->attachments, true);
        $attachments = $supportTicket->attachments ? json_decode($supportTicket->attachments, true) : [];

        // Get all support ticket statuses
        $supportTicketStatus = SupportTicketStatus::where('is_active', 1)->get();

        // Get all support ticket priority
        $supportTicketPriorities = SupportTicketPriority::where('is_active', 1)->get();

        // Get all support ticket replies
        $supportTicketReplies = SupportTicketReply::where('support_ticket_id', $supportTicket->id)
            ->orderBy('id', 'asc')
            ->get();

        // Authorize check to view audits records
        $audits = $supportTicket->audits()
            ->latest()
            ->paginate(10);

        // ajax request to refresh audit log after delete
        if (request()->ajax()) {
            return response()->json($audits);
        }

        return view('admin.support-ticket.show', [
            'supportTicket' => $supportTicket,
            'attachments' => $attachments,
            'supportTicketStatus' => $supportTicketStatus,
            'supportTicketPriorities' => $supportTicketPriorities,
            'supportTicketReplies' => $supportTicketReplies,
            'audits' => $audits,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicket $supportTicket)
    {
        // Check Authorize
        Gate::authorize('update', $supportTicket);

        // Get all active suport ticket statuses
        $ticketStatuses = SupportTicketStatus::where('is_active', 1)->get();

        // Get all active suport ticket priority
        $ticketPriorities = SupportTicketPriority::where('is_active', 1)->get();

        return view('admin.support-ticket.edit', [
            'supportTicket' => $supportTicket,
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
        Gate::authorize('update', $supportTicket);

        // Validate data
        $validated = $request->validated();

        // Retrieve all the uploaded images from the session variable
        $uploadedAttachments = session()->get('uploaded_attachments');

        if (!empty($uploadedAttachments)) {
            $validated['attachments'] = json_encode($uploadedAttachments);
        }

        // Update record in database
        $supportTicket->update($validated);

        // Flash message
        session()->flash('success', 'Support Ticket has been updated successfully!');

        // Clear the uploaded_attachments session variable
        session()->forget('uploaded_attachments');

        return $this->saveAndRedirect($request, 'support-tickets', $supportTicket->id);
    }

    /**
     * Show Audit Log
     */
    public function audit(Request $request)
    {
        // Check Authorize
        Gate::authorize('view', SupportTicket::class);

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
        Gate::authorize('delete', SupportTicket::class);

        if (request()->ajax()) {
            $auditLog = Audit::find($request->id);
            $auditLog->delete();
            return response()->json(['status' => 1]);
        }

        session()->flash('success', 'Log deleted successfully');
        return redirect()->route('admin.support-tickets.index');
    }

    /**
     * Upload attachments
     */
    public function uploadAttachments(Request $request)
    {
        // Get the uploaded image
        $image = $request->file('attachments');

        // File Name
        $filename = rand(1, 9999) . '-' . time() . '.' . $image->extension();

        // Store the uploaded image in a session variable
        session()->push('uploaded_attachments', $image->storeAs('support-tickets/attachments', $filename, 'public'));

        return response()->json(['message' => 'Image uploaded successfully!']);
    }

    /**
     * Support Ticket Reply
     */
    public function ticketReply(Request $request, SupportTicket $supportTicketId)
    {
        // Check Authorize
        Gate::authorize('view', $supportTicketId);

        // Update only status
        if ($request->has('updateStatus')) {
            // Validate data
            $validated = $request->validate([
                'admin_id' => 'nullable|exists:admins,id',
                'department_id' => 'nullable|exists:departments,id',
                'support_ticket_status_id' => 'required|exists:support_ticket_statuses,id',
                'support_ticket_priority_id' => 'required|exists:support_ticket_priorities,id',
            ]);

            $supportTicketId->update([
                'admin_id' => $request->admin_id,
                'department_id' => $request->department_id,
                'support_ticket_status_id' => $request->support_ticket_status_id,
                'support_ticket_priority_id' => $request->support_ticket_priority_id,
            ]);

            session()->flash('success', 'Support Ticket status been changed successfully!');

            return redirect()->route('admin.support-tickets.show', $supportTicketId->id);
        }

        // Validate data
        $validated = $request->validate([
            'message' => 'required',
            'attachments' => [
                'nullable',
                'array',
            ],
            'attachments.*' => [ // This applies to each file in the attachments array
                'file',
                'mimes:jpeg,png,jpg,doc,docx,xls,xlsx,csv,pdf', // Allowed file types
                'max:51200', // Max file size in kilobytes (20MB)
            ],
        ]);

        // Update record in database
        $supportTicketReply = new SupportTicketReply();
        $supportTicketReply->support_ticket_id = $supportTicketId->id;
        $supportTicketReply->staff_reply_by = auth()->guard('admin')->user()->id;
        $supportTicketReply->message = $request->message;

        // Retrieve all the uploaded images from the session variable
        $uploadedAttachments = session()->get('uploaded_attachments');

        if (!empty($uploadedAttachments)) {
            $validated['attachments'] = json_encode($uploadedAttachments);
            $supportTicketReply->attachments = implode(',', $uploadedAttachments);
        }

        $supportTicketReply->save();

        session()->flash('success', 'Support Ticket Reply has been created successfully!');

        // Clear the uploaded_attachments session variable
        session()->forget('uploaded_attachments');

        return redirect()->route('admin.support-tickets.show', $supportTicketId->id);
    }
}
