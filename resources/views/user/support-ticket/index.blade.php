@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'My Support Tickets',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('user.support-ticket.support-ticket-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
