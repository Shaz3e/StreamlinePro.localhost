<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Update Profile</div>
            <form action="{{ route('profile.store', $user->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('post')
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- /.row --}}
                    <div class="row mb-3">
                        <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" name="last_name" id="last_name" class="form-control"
                                value="{{ old('last_name', $user->last_name) }}" required>
                            @error('last_name')
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
                    <div class="row mb-3">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" name="address" id="address" class="form-control"
                                value="{{ old('address', $user->address) }}" required>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- /.row --}}
                    <div class="row mb-3">
                        <label for="country_id" class="col-sm-2 col-form-label">Country</label>
                        <div class="col-md-4 col-sm-4">
                            <select id="country_id" name="country_id" class="form-control">
                                <option value="">Select</option>
                                @if ($user->country)
                                    <option value="{{ $user->country->id }}" selected>{{ $user->country->name }}
                                    </option>
                                @endif
                            </select>
                            @error('country_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- /.row --}}
                    <div class="row mb-3">
                        <label for="city" class="col-sm-2 col-form-label">City</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" name="city" id="city" class="form-control"
                                value="{{ old('city', $user->city) }}" required>
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- /.row --}}
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ old('phone', $user->phone) }}" maxlength="20" required>
                            @error('phone')
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

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        // Search Country
        $('#country_id').select2({
            ajax: {
                url: '{{ route('search.countries') }}',
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
    </script>
@endpush
