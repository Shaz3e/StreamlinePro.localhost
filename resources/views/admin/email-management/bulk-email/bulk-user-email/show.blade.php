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

    {{-- Email  --}}
    <div class="row">
        <div class="col-12">
            <h2>{{ $bulkEmailUser->subject }}</h2>
            {!! $bulkEmailUser->content !!}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}

    {{-- Email Summary --}}
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="card-text">Send Date</div>
            <h4 class="card-title">
                {{ $bulkEmailUser->send_date->format('l, F j, Y H:i A') }}
            </h4>
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6">
            <div class="card-text">Publish Status</div>
            <h4 class="card-title">
                @if ($bulkEmailUser->is_publish)
                    <span class="badge bg-success">Published</span>
                @else
                    <span class="badge bg-info">Draft</span>
                @endif
            </h4>
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6">
            <div class="card-text">Sending Status</div>
            <h4 class="card-title">
                @if ($bulkEmailUser->is_sent)
                    <span class="badge bg-success">Sent</span>
                @else
                    <span class="badge bg-warning">Pending</span>
                @endif
            </h4>
        </div>
        {{-- /.col --}}
        <div class="col-md-3 col-sm-6">
            <div class="card-text">Created At</div>
            <h4 class="card-title">
                {{ $bulkEmailUser->created_at->format('l, F j, Y H:i A') }}
            </h4>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
