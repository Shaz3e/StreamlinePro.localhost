@extends('components.layouts.auth')

@section('content')
    <div class="s3-container">
        <div class="s3-page">
            <div>
                @if (!is_null(DiligentCreators('register_page_heading')))
                    <h2 class="page-heading">{{ DiligentCreators('register_page_heading') }}</h2>
                @else
                    <h2>Welcome to {{ config('app.name') }}</h2>
                @endif

                @if (!is_null(DiligentCreators('register_page_text')))
                    <div>
                        <p class="page-text">{{ DiligentCreators('register_page_text') }}</p>
                    </div>
                @endif
            </div>
        </div>
        {{-- /.s3-page --}}

        <div class="s3-authbox">
            <div class="container">
                <div class="row m-2">
                    <div class="col-12 text-center">
                        <h2>Register</h2>
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}

                <div class="mx-5">
                    <x-alert-message />
                </div>

                <form action="{{ route('register.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row mx-5">

                        <div class="col-6 mb-3">
                            <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <input class="form-control input-mask" name="email" data-inputmask="'alias':'email'" placeholder="Email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="Confirm Password" required>
                            @error('confirm_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>

                        <div class="col-12 mb-3">
                            Already registered <a href="{{ route('login') }}">Login</a> here.
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

@if (!is_null(DiligentCreators('register_page_heading_color')) || !is_null(DiligentCreators('register_page_heading_bg_color')))
<style>
    .page-heading {
        padding: 5px 10px;
        display: inline-block;
        color: {{ DiligentCreators('register_page_heading_color') }};
        background-color: {{ DiligentCreators('register_page_heading_bg_color') }};
    }
</style>
@endif
@if (!is_null(DiligentCreators('register_page_text_color')) || !is_null(DiligentCreators('register_page_text_bg_color')))
<style>
    .page-text {
        padding: 5px 10px;
        display: inline-block;
        color: {{ DiligentCreators('register_page_text_color') }};
        background-color: {{ DiligentCreators('register_page_text_bg_color') }};
    }
</style>
@endif
    @if (!is_null(DiligentCreators('register_page_image')))
        <style>
            .s3-page {
                background-image: url("{{ asset('storage/' . DiligentCreators('register_page_image')) }}");
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
