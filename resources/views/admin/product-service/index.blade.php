@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Products & Services',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Product Service List', 'link' => null],
        ],
    ])

    @livewire('admin.product-service.product-service-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
