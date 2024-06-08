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
                        <h2>Your Account is Locked</h2>
                        <p>Please enter your password to continue.</p>
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}

                <div class="mx-5">
                    <x-alert-message />
                </div>

                <form action="{{ route('admin.lock.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row mx-5">
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
                    </div>
                    {{-- /.row --}}
                </form>
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
                padding: 5px 10px;
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
