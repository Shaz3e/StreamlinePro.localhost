@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>A new user has been created.</p>

    <ul>
        <li>Name: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
    </ul>

    <a href="{{ $viewUser }}">View User</a>
@endsection
