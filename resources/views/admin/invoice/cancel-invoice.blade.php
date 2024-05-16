<div class="modal fade" id="cancelInvoice" tabindex="-1" role="dialog" aria-labelledby="cancelInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate id="cancelInvoiceForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelInvoiceLabel">Cancel Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- /.modal-header --}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="cancel_note">Cancel Note</label>
                                <textarea class="form-control" id="cancel_note" name="cancel_note"
                                    required></textarea>
                            </div>
                            @error('cancel_note')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- /.col --}}
                    </div>
                    {{-- /.row --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                    {{-- /.modal-footer --}}
                </div>
                {{-- /.modal-body --}}
            </div>
            {{-- /.modal-content --}}
        </form>
    </div>
    {{-- /.modal-dialog --}}
</div>
{{-- /.modal --}}
@push('scripts')
    <script>
        // Add Payment Form
        $(document).ready(function() {
            $('#cancelInvoiceForm').submit(function(e) {
                e.preventDefault();
                const invoiceId = {{ $invoice->id }};
                var form = $(this);
                // Remove any existing error messages
                $('.alert-danger').remove();
                $.ajax({
                    type: 'POST',
                    url: `{{ route('admin.cancel.invoice', ':id') }}`.replace(':id',
                        invoiceId),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form.serialize(),
                    success: function(data) {
                        // Handle success response                        
                        $('#cancelInvoice').modal('hide');
                        Swal.fire({
                            title: 'Success',
                            text: data.success,
                            icon: 'success',
                            showCancelButton: false
                        });
                        location.reload();
                    },
                    error: function(error) {
                        // Handle error response
                        var errors = error.responseJSON.error;
                        $.each(errors, function(index, value) {
                            // Add error message beneath respective field
                            $('#' + index).parent().append(
                                '<div class="alert alert-danger">' + value +
                                '</div>');
                        });
                    }
                });
            });
        });
    </script>
@endpush
