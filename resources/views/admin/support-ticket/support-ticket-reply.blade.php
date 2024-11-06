<form action="{{ route('admin.support-tickets.reply', $supportTicket->id) }}" method="POST" class="needs-validation"
    novalidate enctype="multipart/form-data">
    @csrf
    <div class="row" id="reply">
        <div class="col-md-8">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-header">
                    <h5 class="card-title">Reply to Ticket</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="message" name="message" id="message" class="form-control textEditor" rows="7">{!! old('message') !!}</textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.col --}}
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
                                    with max 100MB file size allowed.</small>
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
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        <i class="ri-save-line align-middle me-2"></i> Reply to Ticket
                    </button>
                </div>
                {{-- /.card-footer --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
        <div class="col-md-4">
            <div class="card" style="height: calc(100% - 15px)">
                <div class="card-header">
                    <h5 class="card-title">Change</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="admin_id">Assign To</label>
                                <select name="admin_id" id="admin_id" class="form-control">
                                    <option value="">Select</option>
                                    @if ($supportTicket->admin)
                                        <option value="{{ $supportTicket->admin->ids }}" selected>
                                            {{ $supportTicket->admin->name }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                            @error('admin_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="department_id">Change Department</label>
                                <select name="department_id" id="department_id" class="form-control">
                                    <option value="">Select</option>
                                    @if ($supportTicket->department)
                                        <option value="{{ $supportTicket->department->id }}" selected>
                                            {{ $supportTicket->department->name }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                            @error('department_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="support_ticket_status_id">Change Status</label>
                                <select name="support_ticket_status_id" id="support_ticket_status_id"
                                    class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($supportTicketStatus as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $supportTicket->support_ticket_status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('support_ticket_status_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="support_ticket_priority_id">Change Priority</label>
                                <select name="support_ticket_priority_id" id="support_ticket_priority_id"
                                    class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($supportTicketPriorities as $priority)
                                        <option value="{{ $priority->id }}"
                                            {{ $priority->id == $supportTicket->support_ticket_priority_id ? 'selected' : '' }}>
                                            {{ $priority->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('support_ticket_priority_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- /.row --}}
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    <button type="submit" name="updateStatus" class="btn btn-info waves-effect waves-light">
                        <i class="ri-refresh-line align-middle me-2"></i> Update Status
                    </button>
                </div>
                {{-- /.card-footer --}}
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
</form>

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
                url: `{{ route('admin.support-tickets.upload-attachments') }}`,
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
                    // console.log(response);
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
                    // console.error(error);
                    $('#upload-progress').html('Upload failed!');
                }
            });
        });

        // Search
        $(document).ready(function() {
            // init select2
            $('.select2').select2();
            // Search Department
            $('#department_id').select2({
                ajax: {
                    url: '{{ route('admin.search.departments') }}',
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
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table directionality emoticons template paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                /* enable title field in the Image dialog*/
                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                /*
                    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                    images_upload_url: 'postAcceptor.php',
                    here we add custom filepicker only to Image dialog
                */
                file_picker_types: 'image',
                /* and here's our custom image picker*/
                file_picker_callback: (cb, value, meta) => {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];

                        const reader = new FileReader();
                        reader.addEventListener('load', () => {
                            /*
                            Note: Now we need to register the blob in TinyMCEs image blob
                            registry. In the next release this part hopefully won't be
                            necessary, as we are looking to handle it internally.
                            */
                            const id = 'blobid' + (new Date()).getTime();
                            const blobCache = tinymce.activeEditor.editorUpload
                                .blobCache;
                            const base64 = reader.result.split(',')[1];
                            const blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        });
                        reader.readAsDataURL(file);
                    });

                    input.click();
                },
                // content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
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
            })
        });
    </script>
@endpush
