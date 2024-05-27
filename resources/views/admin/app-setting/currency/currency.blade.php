<div class="card">
    <form action="{{ route('admin.settings.currency.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="card-header">
            <h5 class="card-title">Default Currency</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="currency_id">Select Default Currency</label>
                        <select name="currency_id" id="currency_id" class="form-control">
                            <option value="">Select</option>
                            @if ($currency = currency(DiligentCreators('currency')))
                                <option value="{{ $currency['id'] }}" selected>
                                    {{ $currency['name'] }}
                                </option>
                            @endif
                        </select>
                    </div>
                    @error('currency_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- /.card-body --}}
        <div class="card-footer">
            <x-form.button text="Set Default Currency" />
        </div>
        {{-- /.card-footer --}}
    </form>
</div>
{{-- /.card --}}

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Currency List</h5>
    </div>
    <div class="card-body">
        @livewire('admin.currency.currency-list')
    </div>
    {{-- /.card-body --}}
</div>
{{-- /.card --}}

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();

            // Search Users
            $('#currency_id').select2({
                ajax: {
                    url: '{{ route('admin.settings.search.currencies') }}',
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
        });
    </script>
@endpush
