@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Support Tickets',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.support-ticket.support-ticket-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
