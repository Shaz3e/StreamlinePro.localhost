@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Ticket Priority List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.ticket-priority.ticket-priority-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
