<div class="card">
    <form action="{{ route('admin.settings.tawk-to-chat.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card-header">
            <h5 class="card-title">TawkTo LiveChat</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="tawk_to_property" class="col-sm-3 col-form-label">Tawk.to Property ID</label>
                <div class="col-sm-9">
                    <input type="text" name="tawk_to_property" id="tawk_to_property" class="form-control"
                        value="{{ old('tawk_to_property', DiligentCreators('tawk_to_property')) }}" required>
                    @error('tawk_to_property')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
            <div class="row mb-3">
                <label for="tawk_to_widget" class="col-sm-3 col-form-label">Tawk.to Widget ID</label>
                <div class="col-sm-9">
                    <input type="text" name="tawk_to_widget" id="tawk_to_widget" class="form-control"
                        value="{{ old('tawk_to_widget', DiligentCreators('tawk_to_widget')) }}" required>
                    @error('tawk_to_widget')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Save Settings" />
        </div>
        {{-- /.card-footer --}}
    </form>
</div>
{{-- /.card --}}

@push('styles')
@endpush

@push('scripts')
@endpush
