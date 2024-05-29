<form action="{{ route('admin.settings.dashboard.store') }}" method="POST" class="needs-validation" novalidate
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            Allow Roles to access Dashboard Summary
        </div>
        <div class="card-body">
            {{-- Access Task Summary --}}
            <div class="row mb-3">
                <label for="can_access_task_summary" class="col-sm-3 col-form-label">Who Access Task Summary</label>
                <div class="col-sm-9">
                    <select name="can_access_task_summary[]" id="can_access_task_summary" class="form-control select2"
                        multiple>
                        <option value="">Select</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @if (DiligentCreators('can_access_task_summary') && in_array($role->name, json_decode(DiligentCreators('can_access_task_summary'), true))) selected @endif>

                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('can_access_task_summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
            {{-- Access User Summary --}}
            <div class="row mb-3">
                <label for="can_access_user_summary" class="col-sm-3 col-form-label">Who Access User Summary</label>
                <div class="col-sm-9">
                    <select name="can_access_user_summary[]" id="can_access_user_summary" class="form-control select2"
                        multiple>
                        <option value="">Select</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @if (DiligentCreators('can_access_user_summary') && in_array($role->name, json_decode(DiligentCreators('can_access_user_summary'), true))) selected @endif>

                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('can_access_user_summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
            {{-- Access Support Ticket Summary --}}
            <div class="row mb-3">
                <label for="can_access_support_ticket_summary" class="col-sm-3 col-form-label">Who Access Support Ticket
                    Summary</label>
                <div class="col-sm-9">
                    <select name="can_access_support_ticket_summary[]" id="can_access_support_ticket_summary"
                        class="form-control select2" multiple>
                        <option value="">Select</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @if (DiligentCreators('can_access_support_ticket_summary') && in_array($role->name, json_decode(DiligentCreators('can_access_support_ticket_summary'), true))) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('can_access_support_ticket_summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- /.row --}}
            {{-- Access Invoice Summary --}}
            <div class="row mb-3">
                <label for="can_access_invoice_summary" class="col-sm-3 col-form-label">Who Access Invoice Summary</label>
                <div class="col-sm-9">
                    <select name="can_access_invoice_summary[]" id="can_access_invoice_summary"
                        class="form-control select2" multiple>
                        <option value="">Select</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @if (DiligentCreators('can_access_invoice_summary') && in_array($role->name, json_decode(DiligentCreators('can_access_invoice_summary'), true))) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('can_access_invoice_summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
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
</form>

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endpush
