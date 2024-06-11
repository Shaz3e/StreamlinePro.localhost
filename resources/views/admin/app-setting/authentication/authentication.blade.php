<form action="{{ route('admin.settings.authentication.store') }}" method="POST" class="needs-validation" novalidate
    enctype="multipart/form-data">
    @csrf
    {{-- Customer Related Fields --}}
    <div class="card">
        <div class="card-header">
            Customer Related Fields
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-group">
                        <label for="can_user_register">Can User Register</label>
                        <select name="can_user_register" id="can_user_register" class="form-control">
                            <option value="1"
                                {{ old('can_user_register', DiligentCreators('can_user_register')) == 1 ? 'selected' : '' }}>
                                Yes</option>
                            <option value="0"
                                {{ old('can_user_register', DiligentCreators('can_user_register')) == 0 ? 'selected' : '' }}>
                                No</option>
                        </select>
                    </div>
                    @error('can_user_register')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-6">
                    <div class="form-group">
                        <label for="can_user_reset_password">Can User Reset Password</label>
                        <select name="can_user_reset_password" id="can_user_reset_password" class="form-control">
                            <option value="1"
                                {{ old('can_user_reset_password', DiligentCreators('can_user_reset_password')) == 1 ? 'selected' : '' }}>
                                Yes</option>
                            <option value="0"
                                {{ old('can_user_reset_password', DiligentCreators('can_user_reset_password')) == 0 ? 'selected' : '' }}>
                                No</option>
                        </select>
                    </div>
                    @error('can_user_reset_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Save" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}

    {{-- Admin/Staff Related Fields --}}
    <div class="card">
        <div class="card-header">Admin/Staff Related Fields</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <div class="form-group">
                        <label for="can_admin_register">Can Admin/Staff Register</label>
                        <select name="can_admin_register" id="can_admin_register" class="form-control">
                            <option value="1"
                                {{ old('can_admin_register', DiligentCreators('can_admin_register')) == 1 ? 'selected' : '' }}>
                                Yes</option>
                            <option value="0"
                                {{ old('can_admin_register', DiligentCreators('can_admin_register')) == 0 ? 'selected' : '' }}>
                                No</option>
                        </select>
                    </div>
                    @error('can_admin_register')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-6">
                    <div class="form-group">
                        <label for="can_admin_reset_password">Can Admin/Staff Reset Password</label>
                        <select name="can_admin_reset_password" id="can_admin_reset_password" class="form-control">
                            <option value="1"
                                {{ old('can_admin_reset_password', DiligentCreators('can_admin_reset_password')) == 1 ? 'selected' : '' }}>
                                Yes</option>
                            <option value="0"
                                {{ old('can_admin_reset_password', DiligentCreators('can_admin_reset_password')) == 0 ? 'selected' : '' }}>
                                No</option>
                        </select>
                    </div>
                    @error('can_admin_reset_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Save" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}

    {{-- Login Page Setting --}}
    <div class="card">
        <div class="card-header">Login Page Setting</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label for="login_page_heading">Page Heading</label>
                        <input type="text" name="login_page_heading" id="login_page_heading" class="form-control"
                            value="{{ old('login_page_heading', DiligentCreators('login_page_heading')) }}">
                    </div>
                    @error('login_page_heading')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="login_page_heading_color">Text Color</label>
                        <input type="text" name="login_page_heading_color" id="login_page_heading_color"
                            class="form-control"
                            value="{{ old('login_page_heading_color', DiligentCreators('login_page_heading_color')) }}">
                    </div>
                    @error('login_page_heading_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="login_page_heading_bg_color">Background Color</label>
                        <input type="text" name="login_page_heading_bg_color" id="login_page_heading_bg_color"
                            class="form-control"
                            value="{{ old('login_page_heading_bg_color', DiligentCreators('login_page_heading_bg_color')) }}">
                    </div>
                    @error('login_page_heading_bg_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label for="login_page_text">Page Text</label>
                        <input type="text" name="login_page_text" id="login_page_text" class="form-control"
                            value="{{ old('login_page_text', DiligentCreators('login_page_text')) }}">
                    </div>
                    @error('login_page_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="login_page_text_color">Text Color</label>
                        <input type="text" name="login_page_text_color" id="login_page_text_color"
                            class="form-control"
                            value="{{ old('login_page_text_color', DiligentCreators('login_page_text_color')) }}">
                    </div>
                    @error('login_page_text_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="login_page_text_bg_color">Background Color</label>
                        <input type="text" name="login_page_text_bg_color" id="login_page_text_bg_color"
                            class="form-control"
                            value="{{ old('login_page_text_bg_color', DiligentCreators('login_page_text_bg_color')) }}">
                    </div>
                    @error('login_page_text_bg_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <label for="login_page_image">Background Image</label>
                        <input type="file" name="login_page_image" id="login_page_image" class="form-control"
                            value="{{ old('login_page_image', DiligentCreators('login_page_image')) }}">
                    </div>
                    <div><small>Only JPG and PNG is allowed with max 5MB file size</small></div>
                    @if (DiligentCreators('login_page_image'))
                        <div>
                            <img src="{{ asset('storage/' . DiligentCreators('login_page_image')) }}" class="w-100">
                        </div>
                    @endif
                    @error('login_page_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Save" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}

    {{-- Register Page Setting --}}
    <div class="card">
        <div class="card-header">Register Page Setting</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label for="register_page_heading">Page Heading</label>
                        <input type="text" name="register_page_heading" id="register_page_heading"
                            class="form-control"
                            value="{{ old('register_page_heading', DiligentCreators('register_page_heading')) }}">
                    </div>
                    @error('register_page_heading')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="register_page_heading_color">Text Color</label>
                        <input type="text" name="register_page_heading_color" id="register_page_heading_color"
                            class="form-control"
                            value="{{ old('register_page_heading_color', DiligentCreators('register_page_heading_color')) }}">
                    </div>
                    @error('register_page_heading_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="register_page_heading_bg_color">Background Color</label>
                        <input type="text" name="register_page_heading_bg_color"
                            id="register_page_heading_bg_color" class="form-control"
                            value="{{ old('register_page_heading_bg_color', DiligentCreators('register_page_heading_bg_color')) }}">
                    </div>
                    @error('register_page_heading_bg_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label for="register_page_text">Page Text</label>
                        <input type="text" name="register_page_text" id="register_page_text" class="form-control"
                            value="{{ old('register_page_text', DiligentCreators('register_page_text')) }}">
                    </div>
                    @error('register_page_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="register_page_text_color">Text Color</label>
                        <input type="text" name="register_page_text_color" id="register_page_text_color"
                            class="form-control"
                            value="{{ old('register_page_text_color', DiligentCreators('register_page_text_color')) }}">
                    </div>
                    @error('register_page_text_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="register_page_text_bg_color">Background Color</label>
                        <input type="text" name="register_page_text_bg_color" id="register_page_text_bg_color"
                            class="form-control"
                            value="{{ old('register_page_text_bg_color', DiligentCreators('register_page_text_bg_color')) }}">
                    </div>
                    @error('register_page_text_bg_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <label for="register_page_image">Background Image</label>
                        <input type="file" name="register_page_image" id="register_page_image"
                            class="form-control"
                            value="{{ old('register_page_image', DiligentCreators('register_page_image')) }}">
                    </div>
                    <div><small>Only JPG and PNG is allowed with max 5MB file size</small></div>
                    @if (DiligentCreators('register_page_image'))
                        <div>
                            <img src="{{ asset('storage/' . DiligentCreators('register_page_image')) }}"
                                class="w-100">
                        </div>
                    @endif
                    @error('register_page_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Save" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}

    {{-- Reset Page Setting --}}
    <div class="card">
        <div class="card-header">Reset Page Setting</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label for="reset_page_heading">Page Heading</label>
                        <input type="text" name="reset_page_heading" id="reset_page_heading" class="form-control"
                            value="{{ old('reset_page_heading', DiligentCreators('reset_page_heading')) }}">
                    </div>
                    @error('reset_page_heading')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="reset_page_heading_color">Text Color</label>
                        <input type="text" name="reset_page_heading_color" id="reset_page_heading_color"
                            class="form-control"
                            value="{{ old('reset_page_heading_color', DiligentCreators('reset_page_heading_color')) }}">
                    </div>
                    @error('reset_page_heading_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="reset_page_heading_bg_color">Background Color</label>
                        <input type="text" name="reset_page_heading_bg_color" id="reset_page_heading_bg_color"
                            class="form-control"
                            value="{{ old('reset_page_heading_bg_color', DiligentCreators('reset_page_heading_bg_color')) }}">
                    </div>
                    @error('reset_page_heading_bg_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label for="reset_page_text">Page Text</label>
                        <input type="text" name="reset_page_text" id="reset_page_text" class="form-control"
                            value="{{ old('reset_page_text', DiligentCreators('reset_page_text')) }}">
                    </div>
                    @error('reset_page_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="reset_page_text_color">Text Color</label>
                        <input type="text" name="reset_page_text_color" id="reset_page_text_color"
                            class="form-control"
                            value="{{ old('reset_page_text_color', DiligentCreators('reset_page_text_color')) }}">
                    </div>
                    @error('reset_page_text_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-3 mb-3">
                    <div class="form-group">
                        <label for="reset_page_text_bg_color">Background Color</label>
                        <input type="text" name="reset_page_text_bg_color" id="reset_page_text_bg_color"
                            class="form-control"
                            value="{{ old('reset_page_text_bg_color', DiligentCreators('reset_page_text_bg_color')) }}">
                    </div>
                    @error('reset_page_text_bg_color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <label for="reset_page_image">Background Image</label>
                        <input type="file" name="reset_page_image" id="reset_page_image" class="form-control"
                            value="{{ old('reset_page_image', DiligentCreators('reset_page_image')) }}">
                    </div>
                    <div><small>Only JPG and PNG is allowed with max 5MB file size</small></div>
                    @if (DiligentCreators('reset_page_image'))
                        <div>
                            <img src="{{ asset('storage/' . DiligentCreators('reset_page_image')) }}" class="w-100">
                        </div>
                    @endif
                    @error('reset_page_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Save" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}

    <div class="row mt-3">
        <div class="col-12">
            <x-form.button text="Save All Registration Setting" />
        </div>
    </div>
</form>

@push('styles')
    <link href="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script>
        $("#login_page_heading_color, #login_page_heading_bg_color, #login_page_text_color, #login_page_text_bg_color, #register_page_heading_color, #register_page_heading_bg_color, #register_page_text_color, #register_page_text_bg_color, #reset_page_heading_color, #reset_page_heading_bg_color, #reset_page_text_color, #reset_page_text_bg_color")
            .spectrum({

                togglePaletteOnly: !0,
                togglePaletteMoreText: "more",
                togglePaletteLessText: "less",
                // showAlpha: false,
                palette: [
                    ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
                    ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
                    ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
                    ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
                    ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
                    ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
                    ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
                    ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
                ]
            });
    </script>
@endpush
