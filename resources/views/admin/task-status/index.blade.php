@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Task Status List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.task-status.task-status-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
