@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>Following company has been restored.</p>

    <ul>
        <li>Name: {{ $company->name }}</li>
        <li>Email: {{ $company->email }}</li>
        <li>Phone: {{ $company->phone }}</li>
        <li>Website: {{ $company->website }}</li>
        <li>Address: {{ $company->address }}</li>
        <li>Country: {{ $company->country }}</li>
        <li>Status: {{ $company->is_active ? 'Active' : 'Inactive' }}</li>
    </ul>

    <a href="{{ $viewCompany }}">View Company</a>
@endsection
