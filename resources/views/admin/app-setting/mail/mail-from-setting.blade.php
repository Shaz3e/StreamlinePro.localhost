<div class="card">
    <form action="{{ route('admin.settings.mail.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card-header">
            <h3 class="card-title">Mail From Settings</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="mail_from_name">Mail From Name</label>
                        <input type="text" name="mail_from_name" id="mail_from_name" class="form-control"
                            value="{{ old('mail_from_name', config('mail.from.name')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="mail_from_address">Mail From Address</label>
                        <input type="email" name="mail_from_address" id="mail_from_address" class="form-control"
                            value="{{ old('mail_from_address', config('mail.from.address')) }}" required />
                    </div>
                </div>
                {{-- /.col --}}
                <div class="col-md-12 col-sm-12 mt-3">
                    <label for="daily_email_sending_limit">Daily Email Sending Limit</label>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" name="daily_email_sending_limit" id="daily_email_sending_limit"
                                class="form-control"
                                value="{{ old('daily_email_sending_limit', DiligentCreators('daily_email_sending_limit')) }}"
                                required />
                        </div>
                    </div>
                </div>
                {{-- /.col --}}
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button name="mailFromSetting" text="Save Setting" />
        </div>
        {{-- /.card-footer --}}
    </form>
</div>
{{-- /.card --}}

@push('styles')
@endpush

@push('scripts')
@endpush
