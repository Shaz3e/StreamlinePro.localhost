@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Products',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => null],
        ],
    ])

    @livewire('admin.product.product-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
