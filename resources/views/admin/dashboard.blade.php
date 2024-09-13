@extends('components.layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            Welcome Back <strong>{{ auth()->user()->name }}</strong>
        </div>
    </div>
    @include('admin.dashboard.dashboard')
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
