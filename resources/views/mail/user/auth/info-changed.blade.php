@extends('mail.layouts.user')

@section('content')
    <h2>Dear {{ $user->name }}</h2>
    <p>Your information has been updated successfully.</p>
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

    <a href="{{ $login }}">Login</a>
@endsection
