<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Update Profile</div>
            <form action="{{ route('profile.store', $user->id) }}" method="POST" class="needs-validation"
                novalidate>
                @csrf
                @method('post')
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- /.row --}}
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-md-4 col-sm-4">
                            <input name="email" id="email" class="form-control input-mask"
                                data-inputmask="'alias': 'email'" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- /.row --}}
                </div>
                {{-- /.card-body --}}
                <div class="card-footer">
                    {{-- <button type="submit" name="updateProfile" class="btn btn-success waves-effect waves-light">
                        <i class="ri-save-line align-middle me-2"></i> Update Profile
                    </button> --}}
                    <x-form.button name="updateProfile" text="Update Profile" icon="ri-save-line" />
                </div>
            </form>
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}
