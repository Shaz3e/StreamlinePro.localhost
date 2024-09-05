@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>User password changed successfully.</p>

    <ul>
        <li>Name: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>

    <a href="{{ $viewUser }}">View User</a>
@endsection
