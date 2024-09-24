@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Leads',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.lead.lead-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
