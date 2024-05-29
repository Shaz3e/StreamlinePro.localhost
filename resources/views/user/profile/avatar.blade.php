<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Change Profile Picture</div>
            <form action="{{ route('profile.store', $user->id) }}" method="POST" class="needs-validation"
                novalidate enctype="multipart/form-data">
                @csrf
                @method('post')
                <input type="hidden" name="selected_avatar" id="selected_avatar" value="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <div class="row">
                                @foreach (range(1, 5) as $i)
                                    <div class="col">
                                        <img class="img-fluid avatar-image"
                                            src="{{ asset('storage/avatars/avatar' . $i . '.png') }}"
                                            onclick="setAvatar('avatars/avatar{{ $i }}.png')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-1 mt-3">
                            <p>You can also upload your own profile picture please use square image with max 2mb file
                                size.</p>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="avatar">Custom Profile Picture</label>
                                <div class="input-group">
                                    <input type="file" name="avatar" id="avatar" class="form-control" multiple>
                                </div>
                                <small class="d-block text-muted">Only JPG, PNG with max 2MB file size allowed.</small>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- /.card-body --}}
                <div class="card-footer" id="allowUploadAvatar" style="display:none;">
                    <x-form.button name="changeAvatar" text="Change Profile Picture" icon="ri-save-line" />
                </div>
            </form>
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}


@push('styles')
@endpush

@push('scripts')
    <script>
        $('#avatar').on('change', function() {
            $('#allowUploadAvatar').show();
        })

        function triggerFileInput() {
            document.getElementById('avatar').click();
        }

        function setAvatar(avatarPath) {
            var avatarInput = document.getElementById('selected_avatar');
            avatarInput.value = avatarPath;

            // Update the label text to display the selected file name
            var fileName = avatarPath.split('/').pop();
            var label = document.querySelector('#avatar');
            label.innerText = fileName;
            $('#allowUploadAvatar').show();
        }
    </script>
@endpush
