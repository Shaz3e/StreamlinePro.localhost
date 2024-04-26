@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Invoice Status List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.invoice-status.invoice-status-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
