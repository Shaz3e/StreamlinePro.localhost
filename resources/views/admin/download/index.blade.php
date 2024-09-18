@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Downloads',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.download.download-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
