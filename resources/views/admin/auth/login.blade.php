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
                        <h2>Login</h2>
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}

                <div class="mx-5">
                    <x-alert-message />
                </div>

                <form action="{{ route('admin.login.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row mx-5">
                        <div class="col-12 mb-2">
                            <input name="email" class="form-control input-mask" data-inputmask="'alias': 'email'"
                                placeholder="Email" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>

                        <div class="col-12 mb-">
                            Do not have an account <a href="{{ route('admin.register') }}">Register</a>.
                        </div>
                        <div class="col-12 mb-">
                            Forgot Password <a href="{{ route('admin.forgot.password') }}">Click here</a> to
                            reset.
                        </div>

                    </div>
                    {{-- /.row --}}
                </form>
                <div class="row mx-5">
                    <div class="col-md-12">
                        <div class="d-grid">
                            @env('local')
                            <div class="mb-2">
                                <x-login-link label="Login as SuperAdmin" email="superadmin@shaz3e.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('admin.dashboard') }}" guard="admin" />
                            </div>
                            <div class="mb-2">
                                <x-login-link label="Login as Admin" email="admin@shaz3e.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('admin.dashboard') }}" guard="admin" />
                            </div>
                            <div class="mb-2">
                                <x-login-link label="Login as Manager" email="manager@shaz3e.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('admin.dashboard') }}" guard="admin" />
                            </div>
                            <div class="mb-2">
                                <x-login-link label="Login as Staff" email="staff@shaz3e.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('admin.dashboard') }}" guard="admin" />
                                @endenv
                            </div>
                        </div>
                    </div>
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
        <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $(".input-mask").inputmask()
            });
        </script>
    @endpush
