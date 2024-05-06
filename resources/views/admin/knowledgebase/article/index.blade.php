@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Knowledgebase Articles',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View Article List', 'link' => null],
        ],
    ])

    @livewire('admin.knowledgebase.article.article-list')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
