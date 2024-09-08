@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Notifications',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.notification.notification-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
