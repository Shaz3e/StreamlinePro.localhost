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
                        <h2>Reset your password</h2>
                    </div>
                    {{-- /.col --}}
                </div>
                {{-- /.row --}}

                <div class="mx-5">
                    <x-alert-message />
                </div>

                <form action="{{ route('forgot.password.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row mx-5">
                        <div class="col-12 mb-2">
                            <input name="email" id="email" class="form-control input-mask"
                                data-inputmask="'alias': 'email'" placeholder="Email" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
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
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".input-mask").inputmask()
        });
    </script>
@endpush
