@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'My Task List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Task List', 'link' => null],
        ],
    ])

    @livewire('admin.task.task-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
