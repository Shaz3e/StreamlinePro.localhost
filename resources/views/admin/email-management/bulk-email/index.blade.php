@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Bulk Emails',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.email-management.bulk-email.bulk-email-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
