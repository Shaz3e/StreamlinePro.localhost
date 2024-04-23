@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'My Todo List',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Todo List', 'link' => null],
        ],
    ])

    @livewire('admin.todo.todo-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
