<div class="card">

    <form action="{{ route('admin.settings.mail.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card-header">
            <h3 class="card-title">Backup SMTP Settings</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="backup_smtp_email">Email</label>
                        <input type="email" name="backup_smtp_email" id="backup_smtp_email" class="form-control"
                            value="{{ old('backup_smtp_email', config('mail.mailers.backup_smtp.username')) }}"
                            required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="backup_smtp_password">Password</label>
                        <input type="text" name="backup_smtp_password" id="backup_smtp_password" class="form-control"
                            value="{{ old('backup_smtp_password', config('mail.mailers.backup_smtp.password')) }}"
                            required />
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
            <div class="row mb-3">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="backup_smtp_host">SMTP Host</label>
                        <input type="text" name="backup_smtp_host" id="backup_smtp_host" class="form-control"
                            value="{{ old('backup_smtp_host', config('mail.mailers.backup_smtp.host')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="backup_smtp_port">SMTP Port</label>
                        <input type="text" name="backup_smtp_port" id="backup_smtp_port" class="form-control"
                            value="{{ old('backup_smtp_port', config('mail.mailers.backup_smtp.port')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="backup_smtp_encryptions">SMTP Encryption</label>
                        <select name="backup_smtp_encryptions" id="backup_smtp_encryptions" class="form-control"
                            required>
                            <option value="null"
                                {{ config('mail.mailers.backup_smtp.encryption') == null ? 'selected' : '' }}>None
                            </option>
                            <option value="ssl"
                                {{ config('mail.mailers.backup_smtp.encryption') == 'ssl' ? 'selected' : '' }}>SSL
                            </option>
                            <option value="tls"
                                {{ config('mail.mailers.backup_smtp.encryption') == 'tls' ? 'selected' : '' }}>TLS
                            </option>
                        </select>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button name="mailBackupSmtpSetting" text="Save Setting" />
        </div>
        {{-- /.card-footer --}}
    </form>
</div>
{{-- /.card --}}

@push('styles')
@endpush

@push('scripts')
@endpush
