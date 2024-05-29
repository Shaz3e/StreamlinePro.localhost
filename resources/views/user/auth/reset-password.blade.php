@extends('components.layouts.auth')

@section('content')
    <div class="s3-container">
        <div class="s3-page">
            <div>
                @if (!is_null(DiligentCreators('reset_page_heading')))
                    <h2 class="page-heading">{{ DiligentCreators('reset_page_heading') }}</h2>
                @else
                    <h2>Welcome to {{ config('app.name') }}</h2>
                @endif

                @if (!is_null(DiligentCreators('reset_page_text')))
                    <div>
                        <p class="page-text">{{ DiligentCreators('reset_page_text') }}</p>
                    </div>
                @endif
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

                <form action="{{ route('password.reset.store') }}" method="POST" class="needs-validation" novalidate>
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
                            <a href="{{ route('login') }}">Login</a>
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
@if (!is_null(DiligentCreators('reset_page_heading_color')) || !is_null(DiligentCreators('reset_page_heading_bg_color')))
    <style>
        .page-heading {
            padding: 5px 10px;
            display: inline-block;
            color: {{ DiligentCreators('reset_page_heading_color') }};
            background-color: {{ DiligentCreators('reset_page_heading_bg_color') }};
        }
    </style>
@endif
@if (!is_null(DiligentCreators('reset_page_text_color')) || !is_null(DiligentCreators('reset_page_text_bg_color')))
    <style>
        .page-text {
            padding: 5px 10px;
            display: inline-block;
            color: {{ DiligentCreators('reset_page_text_color') }};
            background-color: {{ DiligentCreators('reset_page_text_bg_color') }};
        }
    </style>
@endif
    @if (!is_null(DiligentCreators('reset_page_image')))
        <style>
            .s3-page {
                background-image: url("{{ asset('storage/' . DiligentCreators('reset_page_image')) }}");
                background-repeat: no-repeat;
                background-position: center center;
                background-size: cover;
            }
        </style>
    @endif
@endpush


@push('scripts')
@endpush
