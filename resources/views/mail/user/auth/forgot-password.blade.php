@extends('mail.layouts.user')

@section('content')
    <h2>Dear {{ $mailData['name'] }}</h2>
    <p>We have received your password reset request. If you made this request please click the link below to change your
        password.</p>
    <p>If you did not made this request, please ignore this email and your password remain unchanged.</p>

    <a href="{{ $mailData['url'] }}">Change Password</a>
@endsection
