@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Task Label List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.task-label.task-label-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
