@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'My Profile',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'My Profile', 'link' => null],
        ],
    ])
    
    {{-- My details --}}
    @include('user.profile.information')
    
    {{-- Change Avatar --}}
    @include('user.profile.avatar')

    {{-- Change Password --}}
    @include('user.profile.password')
@endsection