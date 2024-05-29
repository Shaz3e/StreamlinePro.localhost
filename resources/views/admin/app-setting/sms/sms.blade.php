<div class="card">
    <form action="{{ route('admin.settings.sms.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card-header">
            <h5 class="card-title">Default SMS Provider</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="twilio_sid" class="col-sm-2 col-form-label">Twilio SID</label>
                <div class="col-sm-10">
                    <input type="text" name="twilio_sid" id="twilio_sid" class="form-control"
                        value="{{ old('twilio_sid', config('twilio.sid')) }}" required>
                    @error('twilio_sid')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
            <div class="row mb-3">
                <label for="twilio_token" class="col-sm-2 col-form-label">Twilio Token</label>
                <div class="col-sm-10">
                    <input type="text" name="twilio_token" id="twilio_token" class="form-control"
                        value="{{ old('twilio_token', config('twilio.token')) }}" required>
                    @error('twilio_token')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
            <div class="row mb-3">
                <label for="twilio_from" class="col-sm-2 col-form-label">Twilio Number</label>
                <div class="col-sm-10">
                    <input type="text" name="twilio_from" id="twilio_from" class="form-control"
                        value="{{ old('twilio_from', config('twilio.from')) }}" required>
                    @error('twilio_from')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Set Default SMS Provider" />
        </div>
        {{-- /.card-footer --}}
    </form>
</div>
{{-- /.card --}}

@push('styles')
@endpush

@push('scripts')
@endpush
