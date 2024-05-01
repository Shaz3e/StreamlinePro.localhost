@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Todo Label List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.todo-label.todo-label-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
