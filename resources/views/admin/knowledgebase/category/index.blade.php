@extends('components.layouts.app')

@section('content')

    @include('partials.page-header', [
        'title' => 'Knowledgebase Categories',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View Category List', 'link' => null],
        ],
    ])

    @livewire('admin.knowledgebase.category.category-list')

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
