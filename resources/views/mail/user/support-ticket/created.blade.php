@extends('mail.layouts.user')

@section('content')
    <h2>{{ $supportTicket->title }}</h2>
    {!! $supportTicket->message !!}

    <ul>
        <li>Ticket Number: {{ $supportTicket->ticket_number }}</li>
        @if ($supportTicket->department)
            <li>Department: {{ $supportTicket->department->name }}</li>
        @endif
        <li>Status: {{ $supportTicket->status->name }}</li>
        <li>Priority: {{ $supportTicket->priority->name }}</li>
    </ul>

    <a href="{{ $viewSupportTicket }}">View Support Ticket</a>
@endsection
