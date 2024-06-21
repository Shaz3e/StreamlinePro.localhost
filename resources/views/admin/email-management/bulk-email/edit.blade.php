@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Email',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => route('admin.email-management.bulk-emails.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <form action="{{ route('admin.email-management.bulk-emails.update', $bulkEmail) }}" method="POST" class="needs-validation"
        novalidate>
        @csrf
        @method('put')
        <div class="row">
            {{-- Build Email --}}
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="subject">Email Subject <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                        value="{{ old('subject', $bulkEmail->subject) }}" />
                                </div>
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="content">Email Content <span class="text-danger">*</span></label>
                                    <textarea name="content" id="content" class="form-control textEditor">{{ old('content', $bulkEmail->content) }}</textarea>
                                </div>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col left --}}

            {{-- Email Parameters --}}
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        {{-- Check if user_id is present and not null --}}
                        @if (!is_null($bulkEmail->user_id) && !empty($bulkEmail->user_id))
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="user_id">Select Customer</label>
                                    <select name="user_id[]" id="user_id" class="form-control" multiple>
                                        <option value="">Select</option>
                                        @foreach ($bulkEmail->users as $user)
                                            <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        {{-- Check if admin_id is present and not null --}}
                        @if (!is_null($bulkEmail->admin_id) && !empty($bulkEmail->admin_id))
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="admin_id">Select Staff</label>
                                    <select name="admin_id[]" id="admin_id" class="form-control" multiple>
                                        <option value="">Select</option>
                                        @foreach ($bulkEmail->staff as $staff)
                                            <option value="{{ $staff->id }}" selected>{{ $staff->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('admin_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        {{-- Status --}}
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="is_publish">Status <span class="text-danger">*</span></label>
                                <select name="is_publish" class="form-control" id="is_publish">
                                    <option value="0" {{ $bulkEmail->is_publish == 0 ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="1" {{ $bulkEmail->is_publish == 0 ? 'selected' : '' }}>Publish
                                    </option>
                                </select>
                            </div>
                            @error('is_publish')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="send_date">Publish On <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="send_date" id="send_date"
                                    value="{{ old('send_date', $bulkEmail->send_date) }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">
                            </div>
                            <small class="text-muted">Email will be sent on this date time</small>
                            @error('send_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- /.col --}}
                    </div>
                    {{-- /.card-body --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col right --}}
            <div class="col-12 mb-5">
                <x-form.button />
                <x-form.button-save-view />
                <x-form.button-save-create-new />
            </div>
        </div>
        {{-- /.row --}}
    </form>
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2();

            // Change invoice to option based on radio check
            $('[name="send_to"]').change(function() {
                if ($(this).val() == 'user') {
                    $('#send_to_user').show();
                    $('#send_to_staff').hide();
                } else {
                    $('#send_to_user').hide();
                    $('#send_to_staff').show();
                }
            });

            // Search Users
            $('#user_id').select2({
                ajax: {
                    url: '{{ route('admin.search.users') }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    }
                },
                minimumInputLength: 3
            });
            // Search Staff
            $('#admin_id').select2({
                ajax: {
                    url: '{{ route('admin.search.staff') }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    }
                },
                minimumInputLength: 3
            });

            0 < $(".textEditor").length && tinymce.init({
                selector: "textarea.textEditor",
                height: 500,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table directionality emoticons template paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [{
                        title: "Bold text",
                        inline: "b"
                    },
                    {
                        title: "Red text",
                        inline: "span",
                        styles: {
                            color: "#ff0000"
                        }
                    }, {
                        title: "Red header",
                        block: "h1",
                        styles: {
                            color: "#ff0000"
                        }
                    }, {
                        title: "Example 1",
                        inline: "span",
                        classes: "example1"
                    }, {
                        title: "Example 2",
                        inline: "span",
                        classes: "example2"
                    }, {
                        title: "Table styles"
                    }, {
                        title: "Table row 1",
                        selector: "tr",
                        classes: "tablerow1"
                    }
                ]
            });
        });
    </script>
@endpush
