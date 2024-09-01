<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\SupportTicket;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketReply;
use App\Models\SupportTicketStatus;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.support-ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', 1)->get();

        return view('user.support-ticket.create', [
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'message' => 'required',
            'attachments' => 'nullable|array|validate_each:mimes:jpeg,png|max:2048',
        ]);

        // Generate a Ticket Number
        $ticketNumber = 'TKT-' . time() . '-' . date('d-m-y');

        // Provide a ticket number as generated above
        $validated['ticket_number'] = $ticketNumber;

        // Retrieve all the uploaded images from the session variable
        $uploadedAttachments = session()->get('uploaded_attachments');

        if (!empty($uploadedAttachments)) {
            $validated['attachments'] = json_encode($uploadedAttachments);
        }

        // Update record in database
        $supportTicket = new SupportTicket();

        $supportTicket->ticket_number = $ticketNumber;
        $supportTicket->user_id = auth()->user()->id;
        $supportTicket->department_id = $validated['department_id'];
        $supportTicket->title = $validated['title'];
        $supportTicket->message = $validated['message'];
        $supportTicket->support_ticket_status_id = 1;
        $supportTicket->support_ticket_priority_id = 2;
        if (isset($validated['attachments'])) {
            $supportTicket->attachments = $validated['attachments'];
        }

        $supportTicket->save();

        // Forget uploaded_attachments Session
        session()->forget('uploaded_attachments');

        // Redirect
        return redirect()->route('support-tickets.index')->with('success', 'Support Ticket Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        // Check if the ticket exists and belongs to the authenticated user or if it's internal
        if (!$supportTicket || $supportTicket->user_id !== auth()->user()->id || $supportTicket->is_internal) {
            return redirect()->route('support-tickets.index')->with('error', 'Support Ticket does not exist');
        }

        // Get attachments
        $attachments = $supportTicket->attachments ? json_decode($supportTicket->attachments, true) : [];

        // Get all support ticket statuses
        $supportTicketStatus = SupportTicketStatus::where('is_active', 1)->get();

        // Get all support ticket priority
        $supportTicketPriorities = SupportTicketPriority::where('is_active', 1)->get();

        // Get all support ticket replies
        $supportTicketReplies = SupportTicketReply::where('support_ticket_id', $supportTicket->id)
            ->orderBy('id', 'asc')
            ->get();

        return view('user.support-ticket.show', [
            'supportTicket' => $supportTicket,
            'attachments' => $attachments,
            'supportTicketReplies' => $supportTicketReplies,
            'supportTicketStatus' => $supportTicketStatus,
            'supportTicketPriorities' => $supportTicketPriorities,
        ]);
    }

    /**
     * Support Ticket Reply
     */
    public function ticketReply(Request $request, SupportTicket $supportTicketId)
    {
        // Update only status
        if ($request->has('updateStatus')) {
            // Validate data
            $validated = $request->validate([
                'support_ticket_status_id' => 'required|exists:support_ticket_statuses,id',
                'support_ticket_priority_id' => 'required|exists:support_ticket_priorities,id',
            ]);

            $supportTicketId->update([
                'support_ticket_status_id' => $validated['support_ticket_status_id'],
                'support_ticket_priority_id' => $validated['support_ticket_priority_id'],
            ]);

            session()->flash('success', 'Support Ticket status been changed successfully!');

            return redirect()->route('support-tickets.show', $supportTicketId->id);
        }

        // Validate data
        $validated = $request->validate([
            'message' => 'required',
            'attachments' => [
                'nullable',
                'array',
                'validate_each:mimes:jpeg,png',
                'max:2048',
            ],
        ]);

        // Update record in database
        $supportTicketReply = new SupportTicketReply();
        $supportTicketReply->support_ticket_id = $supportTicketId->id;
        $supportTicketReply->client_reply_by = auth()->user()->id;
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

        return back()->with('success', 'Your Response has been updated');
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
}
