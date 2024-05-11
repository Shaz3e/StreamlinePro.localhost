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
                                <textarea name="message" name="message" id="message" class="form-control" rows="7">{!! old('message') !!}</textarea>
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
                                <small class="d-block text-muted">Only JPG, PNG with max 2MB file size allowed.</small>
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
                                    @foreach ($staffList as $staff)
                                        <option value="{{ $staff->id }}"
                                            {{ $supportTicket->admin_id == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }}</option>
                                    @endforeach
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
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $supportTicket->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
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
                                    class="form-control">
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
                                    class="form-control">
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

@push('scripts')
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
    </script>
@endpush
