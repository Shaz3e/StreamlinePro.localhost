@extends('mail.layouts.user')

@section('content')
    <h2>{{ $supportTicketReply->supportTicket->title }}</h2>
    {!! $supportTicketReply->message !!}

    <ul>
        <li>Ticket Number: {{ $supportTicketReply->supportTicket->ticket_number }}</li>
        @if ($supportTicketReply->supportTicket->department)
            <li>Department: {{ $supportTicketReply->supportTicket->department->name }}</li>
        @endif
        <li>Status: {{ $supportTicketReply->supportTicket->status->name }}</li>
        <li>Priority: {{ $supportTicketReply->supportTicket->priority->name }}</li>
    </ul>

    <a href="{{ $viewSupportTicketReply }}">View Support Ticket</a>
@endsection
