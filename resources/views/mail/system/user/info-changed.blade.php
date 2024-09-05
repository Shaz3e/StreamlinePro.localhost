@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>User information changed successfully.</p>

    <ul>
        <li>First Name: {{ $user->first_name }}</li>
        <li>Last Name: {{ $user->last_name }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Phone: {{ $user->phone }}</li>
        <li>Address: {{ $user->address }}</li>
        <li>City: {{ $user->city }}</li>
        <li>Country: {{ $user->country->name }}</li>
        <li>Status: {{ $user->is_active ? 'Active' : 'Inactive' }}</li>
    </ul>

    <a href="{{ $viewUser }}">View User</a>
@endsection
