@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Todo Status List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.todo-status.todo-status-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
