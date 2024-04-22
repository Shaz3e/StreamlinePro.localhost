@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Departments',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.department.department-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
