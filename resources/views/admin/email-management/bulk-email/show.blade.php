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
                @if ($bulkEmail->user_id)
                    @foreach ($bulkEmail->users as $user)
                        {{ $user->name }}
                    @endforeach
                @endif
                @if ($bulkEmail->admin_id)
                    @foreach ($bulkEmail->staff as $staff)
                        {{ $staff->name }}
                    @endforeach
                @endif
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <h4 class="card-title">Status: </h4>
            <div class="card-text">
                {!! $bulkEmail->getPublishStatusBadge() !!}
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <h4 class="card-title">Sent: </h4>
            <div class="card-text">
                {!! $bulkEmail->getSentStatusBadge() !!}
            </div>
        </div>
        {{-- /.col --}}
        <div class="col-md-3">
            <h4 class="card-title">Date: </h4>
            <div class="card-text">
                {{ $bulkEmail->send_date->format('l, jS M Y h:i A') }}
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
                        {{ $bulkEmail->subject }}
                    </div>
                </div>
                {{-- /.card-body --}}
                <div class="card-body">
                    <div class="card-text">
                        {{ $bulkEmail->subject }}
                    </div>
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small class="d-block">Created At</small>
                            {{ $bulkEmail->created_at->format('l, jS M Y h:i A') }}
                        </div>
                        {{-- /.col left --}}
                        <div class="col-6 text-end">
                            <small class="d-block">Updated At</small>
                            {{ $bulkEmail->updated_at->format('l, jS M Y h:i A') }}
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
                @if ($bulkEmail->is_sent)
                    <small>Sent email is not editable.</small>
                @else
                    <a href="{{ route('admin.email-management.bulk-emails.edit', $bulkEmail->id) }}">
                        <i class="ri-pencil-line"></i> Edit
                    </a>
                @endif
            </div>
        </div>
    @endcan
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
