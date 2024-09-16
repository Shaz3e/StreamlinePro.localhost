@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Edit User',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Users', 'link' => route('admin.users.index')],
            ['text' => 'Edit', 'link' => null],
        ],
    ])

    {{-- Edit Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control"
                                        value="{{ old('first_name', $user->first_name) }}" maxlength="20" required />
                                </div>
                                @error('first_name')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control"
                                        value="{{ old('last_name', $user->last_name) }}" maxlength="20" required />
                                </div>
                                @error('last_name')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" id="email" class="form-control input-mask"
                                        data-inputmask="'alias': 'email'" value="{{ old('email', $user->email) }}"
                                        required />
                                </div>
                                @error('email')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="password" id="password"
                                            value="{{ old('password') }}" minlength="8" maxlength="64" />
                                        <div class="input-group-append">
                                            <button type="button" id="generatePasswordBtn"
                                                class="btn btn-outline-primary">Generate</button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Leave it blank if you do not want to change password.</small>
                                </div>
                                @error('password')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="company_id">Company</label>
                                    <select id="company_id" name="company_id" class="form-control">
                                        <option value="">Select</option>
                                        @if ($user->company)
                                            <option value="{{ $user->company->id }}">{{ $user->company->name }}</option>
                                        @endif
                                    </select>
                                </div>
                                @error('company_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="country_id">Country</label>
                                    <select id="country_id" name="country_id" class="form-control">
                                        <option value="">Select</option>
                                        @if ($user->country)
                                            <option value="{{ $user->country->id }}" selected>{{ $user->country->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                @error('country_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control"
                                        value="{{ old('city', $user->city) }}" />
                                </div>
                                @error('city')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="tel" name="phone" id="phone" class="form-control"
                                        value="{{ old('phone', $user->phone) }}" maxlength="20" />
                                </div>
                                @error('phone')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        value="{{ old('address', $user->address) }}" />
                                </div>
                                @error('address')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="product_service">Assign Product</label>
                                    <select name="product_service[]" id="product_service" class="form-control select2"
                                        multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ in_array($product->id, old('product_service', $userProductIds)) ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_service')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="is_active">Can Login?</label>
                                    <select name="is_active" id="is_active" class="form-control" required>
                                        <option value="0"
                                            {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1"
                                            {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                @error('is_active')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <x-form.button />
                        <x-form.button-save-view />
                        <x-form.button-save-create-new />
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
    <script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        // Input mask
        $(document).ready(function() {
            $('.select2').select2();
            $(".input-mask").inputmask();
            $("#phone").inputmask({
                mask: '+999999999999',
                placeholder: '+____________',
                greedy: false,
                definations: {
                    '9': {
                        validator: '[0-9]',
                        cardinality: 1
                    }
                }
            });

            // Search Companies
            $('#company_id').select2({
                ajax: {
                    url: '{{ route('admin.search.companies') }}',
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
            // Search Country
            $('#country_id').select2({
                ajax: {
                    url: '{{ route('admin.search.countries') }}',
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

            // Generate Password
            $('#generatePasswordBtn').click(function(e) {
                let characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                let result = '';
                for (let i = 0; i < 8; i++) {
                    result += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                $("#password").val(result);
            });
        });
    </script>
@endpush
