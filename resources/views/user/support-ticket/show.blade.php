@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'View Ticket',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Support Ticket List', 'link' => route('support-tickets.index')],
            ['text' => 'View', 'link' => null],
        ],
    ])

    {{-- Show Ticket Info --}}
    <div class="row">
        <div class="col-md-9">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-md-3">
                            <small>Ticket Number</small><br>
                            <strong>{{ $supportTicket->ticket_number }}</strong>
                        </div>
                        {{-- /.col --}}
                        <div class="col-md-3">
                            <small>Department</small><br>
                            <strong>{{ $supportTicket->department ? $supportTicket->department->name : 'N/A' }}</strong>
                        </div>
                        {{-- /.col --}}
                        <div class="col-md-3">
                            <small>Status</small><br>
                            <strong class="badge"
                                style="background-color:{{ $supportTicket->status->bg_color }};color:{{ $supportTicket->status->text_color }};">
                                {{ $supportTicket->status->name }}
                            </strong>
                        </div>
                        {{-- /.col --}}
                        <div class="col-md-3">
                            <small>Priority</small><br>
                            <strong class="badge"
                                style="background-color:{{ $supportTicket->priority->bg_color }};color: {{ $supportTicket->priority->text_color }};">
                                {{ $supportTicket->priority->name }}
                            </strong>
                        </div>
                        {{-- /.col --}}
                    </div>
                    {{-- /.row --}}

                    <div class="row">
                        <div class="col-md-3">
                            <small>Created at</small><br>
                            <strong>{{ $supportTicket->created_at->format('l, F j, Y') }}</strong>
                        </div>
                        {{-- /.col --}}
                        <div class="col-md-3">
                            <small>Last Updated at</small><br>
                            <strong>{{ $supportTicket->updated_at->format('l, F j, Y') }}</strong>
                        </div>
                        {{-- /.col --}}
                        <div class="col-md-3">
                            <small>Last Replied By</small><br>
                            @if ($supportTicket->lastReply)
                                <strong>
                                    @if ($supportTicket->lastReply->staff_reply_by)
                                        {{ $supportTicket->lastReply->staff->name }}
                                    @elseif($supportTicket->lastReply->client_reply_by)
                                        {{ $supportTicket->lastReply->client->name }}
                                    @else
                                        N/A
                                    @endif
                                </strong>
                            @endif
                        </div>
                        {{-- /.col --}}
                        <div class="col-md-3">
                            <small>Last Reply at</small><br>
                            <strong>
                                {{ optional($supportTicket->lastReply)->created_at ? $supportTicket->lastReply->created_at->format('l, F j, Y') : 'N/A' }}
                            </strong>
                        </div>
                        {{-- /.col --}}
                    </div>
                    {{-- /.row --}}
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <form action="{{ route('support-tickets.reply', $supportTicket->id) }}" method="POST" class="needs-validation"
                novalidate>
                @csrf
                @method('post')
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="support_ticket_status_id">Change Status</label>
                                    <select name="support_ticket_status_id" id="support_ticket_status_id"
                                        class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($supportTicketStatus as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $supportTicket->support_ticket_status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('support_ticket_status_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="support_ticket_priority_id">Change Priority</label>
                                    <select name="support_ticket_priority_id" id="support_ticket_priority_id"
                                        class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($supportTicketPriorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ $priority->id == $supportTicket->support_ticket_priority_id ? 'selected' : '' }}>
                                                {{ $priority->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('support_ticket_priority_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <button type="submit" name="updateStatus" class="btn btn-sm btn-info waves-effect waves-light">
                            <i class="ri-refresh-line align-middle me-2"></i> Update Status
                        </button>
                    </div>
                    {{-- /.card-footer --}}
                </div>
                {{-- /.card --}}
            </form>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Show Ticket Details --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Title: {{ $supportTicket->title }}
                    </h3>
                </div>
                {{-- /.card-header --}}
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            {!! $supportTicket->message !!}
                        </div>
                    </div>
                    {{-- /.row --}}

                    @if (!is_null($attachments))
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong>Attachments</strong>
                                <ul>
                                    @foreach ($attachments as $attachment)
                                        <li>
                                            <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="">
                                                Open
                                            </a>
                                            <a href="{{ asset('storage/' . $attachment) }}" download="{{ $attachment }}"
                                                class="">
                                                Download
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{-- /.row --}}
                    @endif
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <button onclick="scrollToReply()" class="btn btn-info btn-sm"><i class="ri-reply-line"></i> Response to
                        Ticket</button>
                </div>
                {{-- /.card-footer --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    @include('user.support-ticket.support-ticket-replies')
    @include('user.support-ticket.support-ticket-reply')

@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        // Scrolle To Reply
        function scrollToReply() {
            const targetElement = document.getElementById('reply');
            targetElement.scrollIntoView({
                behavior: 'smooth' // Smooth scrolling effect
            });
        }
    </script>
@endpush
