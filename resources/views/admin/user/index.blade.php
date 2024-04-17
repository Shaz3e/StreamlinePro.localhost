@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Users',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.user.user-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
