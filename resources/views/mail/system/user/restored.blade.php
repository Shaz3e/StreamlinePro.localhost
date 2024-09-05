@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>User has been restored.</p>

    <ul>
        <li>Name: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
    </ul>
@endsection
