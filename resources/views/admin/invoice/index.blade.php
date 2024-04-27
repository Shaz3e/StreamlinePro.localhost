@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Invoices',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.invoice.invoice-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
