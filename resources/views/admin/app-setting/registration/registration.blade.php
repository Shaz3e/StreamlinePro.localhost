<form action="{{ route('admin.settings.registration.store') }}" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <h6 class="mt-4">Customer Related Fields</h6>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="can_customer_register">Can Customer Register</label>
                        <select name="can_customer_register" id="can_customer_register" class="form-control">
                            <option value="1"
                                {{ old('can_customer_register', DiligentCreators('can_customer_register')) == 1 ? 'selected' : '' }}>
                                Yes</option>
                            <option value="0"
                                {{ old('can_customer_register', DiligentCreators('can_customer_register')) == 0 ? 'selected' : '' }}>
                                No</option>
                        </select>
                    </div>
                    @error('can_customer_register')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- /.col --}}
                <div class="col-6">
                    <div class="form-group">
                        <label for="can_user_reset_password">Can Customer Reset Password</label>
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
            <div class="row mb-3">
                <div class="col-12">
                    <h6 class="mt-4">Admin/Staff Related Fields</h6>
                </div>
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
            <x-form.button text="Save Registration Setting" />
        </div>
        {{-- /.card-footer --}}
    </div>
    {{-- /.card --}}
</form>
