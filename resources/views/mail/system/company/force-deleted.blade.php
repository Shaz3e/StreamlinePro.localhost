@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>Following company has been deleted and cannot be restored.</p>

    <ul>
        <li>Name: {{ $company->name }}</li>
        <li>Email: {{ $company->email }}</li>
    </ul>
@endsection
