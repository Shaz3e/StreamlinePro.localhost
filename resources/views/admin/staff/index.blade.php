@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Staff',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Staff List', 'link' => null],
        ],
    ])

    @livewire('admin.staff.staff-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
