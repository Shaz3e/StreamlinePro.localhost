@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create Support Tickets',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('dashboard')],
            ['text' => 'Support Ticket List', 'link' => route('support-tickets.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('support-tickets.store') }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="title">Subject <strong class="text-danger">*</strong></label>
                                    <input type="text" id="title" name="title" class="form-control"
                                        value="{{ old('title') }}" required>
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="department_id">Select Department <strong
                                            class="text-danger">*</strong></label>
                                    <select id="department_id" name="department_id" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Ticket Details <strong class="text-danger">*</strong></label>
                                    <textarea id="message" name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                                </div>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="attachments">Attachments (optional)</label>
                                    <div class="input-group">
                                        <input type="file" name="attachments[]" id="attachments" class="form-control"
                                            multiple>
                                    </div>
                                    <small class="d-block text-muted">Only .jpg, .jpeg, .png, .doc, .docx, .xls, .xlsx, .pdf
                                        with max 20MB file size allowed.</small>
                                </div>
                                @error('attachments')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div id="upload-progress"></div>
                                <div class="progress">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        <span>0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}

                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <x-form.button />
                    </div>
                    {{-- /.card-footer --}}
                </form>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!--tinymce js-->
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script>
        $('#attachments').change(function() {
            var file = this.files[0];
            var formData = new FormData();
            formData.append('attachments', file);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax({
                url: `{{ route('support-tickets.upload-attachments') }}`,
                method: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var progress = Math.round(evt.loaded / evt.total * 100);
                            console.log(progress);
                            $('#progress-bar').css('width', progress + '%');
                            $('#upload-progress').html(''); // Clear previous message
                            // disable submitButton button wile uploading
                            $('#submitButton').prop('disabled', true);
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    console.log(response);
                    $('#progress-bar').css('width', '0%'); // Hide progress bar
                    // hide upload successfull after 1 second
                    $('#upload-progress').html('Upload successful!');
                    setTimeout(function() {
                        $('#upload-progress').html('');
                    }, 1000);
                    // enable submitButton when upload finishes
                    $('#submitButton').prop('disabled', false);
                },
                error: function(error) {
                    console.error(error);
                    $('#upload-progress').html('Upload failed!');
                }
            });
        });

        // Search
        $(document).ready(function() {
            // init select2
            $('.select2').select2();

            0 < $("#message").length && tinymce.init({
                selector: "textarea#message",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table directionality emoticons template paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
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
