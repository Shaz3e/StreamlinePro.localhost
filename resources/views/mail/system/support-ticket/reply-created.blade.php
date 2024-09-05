@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>Support TIcket Replied.</p>

    <h2>{{ $supportTicketReply->supportTicket->title }}</h2>
    {!! $supportTicketReply->message !!}

    <ul>
        <li>Ticket Number: {{ $supportTicketReply->supportTicket->ticket_number }}</li>
        <li>Client Name: {{ $supportTicketReply->supportTicket->user->name }}</li>
        @if ($supportTicketReply->supportTicket->department)
            <li>Department: {{ $supportTicketReply->supportTicket->department->name }}</li>
        @endif
        <li>Status: {{ $supportTicketReply->supportTicket->status->name }}</li>
        <li>Priority: {{ $supportTicketReply->supportTicket->priority->name }}</li>
        <li>Private: {{ $supportTicketReply->supportTicket->is_internal ? 'Yes' : 'No' }}</li>
        @if ($supportTicketReply->staff)
            <li>Assigned To: {{ $supportTicketReply->staff->name }}</li>
        @endif
        <li>Reply By:
            @if ($supportTicketReply->client)
                {{ $supportTicketReply->client->name }}
            @endif
            @if ($supportTicketReply->staff)
                {{ $supportTicketReply->staff->name }}
            @endif
        </li>
    </ul>

    <a href="{{ $viewSupportTicketReply }}">View Support Ticket</a>
@endsection
