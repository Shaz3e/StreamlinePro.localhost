@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'View Email',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => route('admin.email-management.bulk-emails.index')],
            ['text' => 'View Email', 'link' => null],
        ],
    ])

    <div class="row mb-3">
        <div class="col-md-3">
            <h4 class="card-title">To: </h4>
            <div class="card-text">
                @if (!is_null($bulkEmailStaff->user_id))
                    @if ($bulkEmailStaff->is_sent_all_users)
                        <span class="badge bg-success">Sent to All Users</span>
                    @else
                        <span class="badge bg-info">{{ count($bulkEmailStaff->user_id) }} </span>
                        User(s)
                    @endif
                @endif
                @if (!is_null($bulkEmailStaff->admin_id))
                    @if ($bulkEmailStaff->is_sent_all_admins)
                        <span class="badge bg-success">Sent to All Staff</span>
                    @else
                        <span class="badge bg-info">{{ count($bulkEmailStaff->admin_id) }} </span>
                        Staff Members
                    @endif
                @endif
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <h4 class="card-title">Status: </h4>
            <div class="card-text">
                {!! $bulkEmailStaff->getPublishStatusBadge() !!}
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <h4 class="card-title">Sent: </h4>
            <div class="card-text">
                {!! $bulkEmailStaff->getSentStatusBadge() !!}
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <h4 class="card-title">Date: </h4>
            <div class="card-text">
                {{ $bulkEmailStaff->send_date->format('l, jS M Y h:i A') }}
            </div>
        </div>
        {{-- /.col left --}}
    </div>
    {{-- /.row --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Subject: </h4>
                    <div class="card-text">
                        {{ $bulkEmailStaff->subject }}
                    </div>
                </div>
                {{-- /.card-body --}}
                <div class="card-body">
                    <div class="card-text">
                        {{ $bulkEmailStaff->subject }}
                    </div>
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small class="d-block">Created At</small>
                            {{ $bulkEmailStaff->created_at->format('l, jS M Y h:i A') }}
                        </div>
                        {{-- /.col left --}}
                        <div class="col-6 text-end">
                            <small class="d-block">Updated At</small>
                            {{ $bulkEmailStaff->updated_at->format('l, jS M Y h:i A') }}
                        </div>
                        {{-- /.col right --}}
                    </div>
                    {{-- /.row --}}
                </div>
                {{-- /.card-footer --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    @can('bulk-email.update')
        <div class="row">
            <div class="col-12">
                @if ($bulkEmailStaff->is_sent)
                    <small>Sent email is not editable.</small>
                @else
                    <a href="{{ route('admin.email-management.bulk-emails.edit', $bulkEmailStaff->id) }}">
                        <i class="ri-pencil-line"></i> Edit
                    </a>
                @endif
            </div>
        </div>
    @endcan

    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Sent Date</th>
                                    <th>Sent At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emailList as $emailData)
                                    <tr>
                                        <td>{{ $emailData->email }}</td>
                                        <td>{{ $emailData->send_date->format('l, jS M Y h:i A') }}</td>
                                        <td>
                                            @if ($emailData->sent_at)
                                                {{ $emailData->sent_at->format('l, jS M Y h:i A') }}
                                            @else
                                                <span class="badge bg-dark">Scheduled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $emailData->getStatusColor() }}">
                                                {{ $emailData->getStatus() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- /.table-responsive --}}

                    {{ $emailList->links('pagination::bootstrap-5') }}
                </div>
                {{-- /.card-body --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
