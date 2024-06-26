@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'View Email',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => route('admin.email-management.bulk-emails.index')],
            ['text' => 'View Email', 'link' => null],
        ],
    ])
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
