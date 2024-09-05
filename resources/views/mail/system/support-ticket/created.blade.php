@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>New support ticket created.</p>

    <h2>{{ $supportTicket->title }}</h2>
    {!! $supportTicket->message !!}

    <ul>
        <li>Ticket Number: {{ $supportTicket->ticket_number }}</li>
        <li>Name:
            <a href="{{ route('admin.users.show', $supportTicket->user->id) }}">
                {{ $supportTicket->user->name }}
            </a>
        </li>
        @if ($supportTicket->department)
            <li>Department: {{ $supportTicket->department->name }}</li>
        @endif
        <li>Status: {{ $supportTicket->status->name }}</li>
        <li>Priority: {{ $supportTicket->priority->name }}</li>
        <li>Private: {{ $supportTicket->is_internal ? 'Yes' : 'No' }}</li>
        @if ($supportTicket->admin)
            <li>Assigned To: {{ $supportTicket->admin->name }}</li>
        @endif
    </ul>

    <a href="{{ $viewSupportTicket }}">View Support Ticket</a>
@endsection
