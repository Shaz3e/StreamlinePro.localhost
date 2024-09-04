@extends('mail.layouts.user')

@section('content')
    <h2>Dear {{ $user->name }}</h2>
    <p>Your password has been changed successfully.</p>

    <ul>
        <li>Email: {{ $user->email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>

    <a href="{{ $login }}">Login</a>
@endsection
