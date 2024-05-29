@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Ticket Status List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.ticket-status.ticket-status-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
