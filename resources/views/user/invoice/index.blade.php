@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'My Invoices',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('user.invoice.invoice-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
