@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Invoice Label List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.invoice-label.invoice-label-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
