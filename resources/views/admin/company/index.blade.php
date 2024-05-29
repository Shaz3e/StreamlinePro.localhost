@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Companies',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.company.company-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
