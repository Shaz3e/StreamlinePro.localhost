@extends('components.layouts.auth')

@section('content')
    <div class="s3-container">
        <div class="s3-page">
            <div>
                <h2>Welcome to {{ config('app.name') }}</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis arcu ut dolor placerat tincidunt ut nec
                    odio.</p>
            </div>
        </div>
        {{-- /.s3-page --}}

        <div class="s3-authbox">
            <div class="container">
                <div class="row m-2">
                    <div class="col-12 text-center">
                        <h2>Change your password</h2>
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}

                <x-alert-message />

                <form action="{{ route('admin.password.reset.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ request('token') }}">
                    <input type="hidden" name="email" value="{{ request('email') }}">
                    <div class="row mx-5">
                        <div class="col-12 mb-2">
                            <input type="password" name="password" class="form-control" placeholder="password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="Confirm Password" required>
                            @error('confirm_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary">
                                Change Password
                            </button>
                        </div>

                        <div class="col-12 mb-">
                            <a href="{{ route('admin.login') }}">Login</a>
                        </div>

                    </div>

                </form>
            </div>
            {{-- /.container --}}
        </div>
        {{-- /.s3-authbox --}}
    </div>
    {{-- /.s3-container --}}
@endsection


@push('styles')
@endpush


@push('scripts')
@endpush
