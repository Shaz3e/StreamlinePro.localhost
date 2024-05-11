@extends('components.layouts.auth')

@section('content')
    <div class="s3-container">
        <div class="s3-page">
            <div>
                @if (!is_null(DiligentCreators('login_page_heading')))
                    <h2 class="page-heading">{{ DiligentCreators('login_page_heading') }}</h2>
                @else
                    <h2>Welcome to {{ config('app.name') }}</h2>
                @endif

                @if (!is_null(DiligentCreators('login_page_text')))
                    <div>
                        <p class="page-text">{{ DiligentCreators('login_page_text') }}</p>
                    </div>
                @endif
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

                <form action="{{ route('login.store') }}" method="POST" class="needs-validation" novalidate>
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
                            Do not have an account <a href="{{ route('register') }}">Register</a>.
                        </div>
                        <div class="col-12 mb-">
                            Forgot Password <a href="{{ route('forgot.password') }}">Click here</a> to
                            reset.
                        </div>

                    </div>
                </form>
                <div class="row mx-5">
                    <div class="col-md-12">
                        <div class="d-grid">
                            @env('local')
                            <div class="mb-2">
                                <x-login-link label="Login as User 1" email="user1@email.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('dashboard') }}" />
                                <x-login-link label="Login as User 2" email="user2@email.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('dashboard') }}" />
                                <x-login-link label="Login as User 3" email="user3@email.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('dashboard') }}" />
                                <x-login-link label="Login as User 4" email="user4@email.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('dashboard') }}" />
                                <x-login-link label="Login as User 5" email="user5@email.com"
                                    class="btn btn-success btn-block btn-sm waves-effect waves-light"
                                    redirect-url="{{ route('dashboard') }}" />
                                @endenv
                            </div>
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
@if (!is_null(DiligentCreators('login_page_heading_color')) || !is_null(DiligentCreators('login_page_heading_bg_color')))
    <style>
        .page-heading {
            padding:5px 10px;
            display: inline-block;
            color: {{ DiligentCreators('login_page_heading_color') }};
            background-color: {{ DiligentCreators('login_page_heading_bg_color') }};
        }
    </style>
@endif
@if (!is_null(DiligentCreators('login_page_text_color')) || !is_null(DiligentCreators('login_page_text_bg_color')))
    <style>
        .page-text {
            padding: 5px 10px;
            display: inline-block;
            color: {{ DiligentCreators('login_page_text_color') }};
            background-color: {{ DiligentCreators('login_page_text_bg_color') }};
        }
    </style>
@endif
    @if (!is_null(DiligentCreators('login_page_image')))
        <style>
            .s3-page {
                background-image: url("{{ asset('storage/' . DiligentCreators('login_page_image')) }}");
                background-repeat: no-repeat;
                background-position: center center;
                background-size: cover;
            }
        </style>
    @endif
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".input-mask").inputmask()
        });
    </script>
@endpush
