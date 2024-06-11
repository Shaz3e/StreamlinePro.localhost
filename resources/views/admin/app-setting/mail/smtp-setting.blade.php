<div class="card">

    <form action="{{ route('admin.settings.mail.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card-header">
            <h3 class="card-title">SMTP Settings</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="smtp_email">Email</label>
                        <input type="email" name="smtp_email" id="smtp_email" class="form-control"
                            value="{{ old('smtp_email', config('mail.mailers.smtp.username')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="smtp_password">Password</label>
                        <input type="text" name="smtp_password" id="smtp_password" class="form-control"
                            value="{{ old('smtp_password', config('mail.mailers.smtp.password')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            <div class="row mb-3">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="smtp_host">SMTP Host</label>
                        <input type="text" name="smtp_host" id="smtp_host" class="form-control"
                            value="{{ old('smtp_host', config('mail.mailers.smtp.host')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="smtp_port">SMTP Port</label>
                        <input type="text" name="smtp_port" id="smtp_port" class="form-control"
                            value="{{ old('smtp_port', config('mail.mailers.smtp.port')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="smtp_encryptions">SMTP Encryption</label>
                        <select name="smtp_encryptions" id="smtp_encryptions" class="form-control" required>
                            <option value="null" {{ config('mail.mailers.smtp.encryption') == null ? 'selected' : '' }}>None</option>
                            <option value="ssl" {{ config('mail.mailers.smtp.encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="tls" {{ config('mail.mailers.smtp.encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                        </select>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button name="mailSmtpSetting" text="Save Setting" />
        </div>
        {{-- /.card-footer --}}
    </form>
</div>
{{-- /.card --}}

@push('styles')
@endpush

@push('scripts')
@endpush
