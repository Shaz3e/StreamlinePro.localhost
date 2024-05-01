@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Invoice',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Invoice List', 'link' => route('admin.invoices.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.invoices.store') }}" method="POST" class="needs-validation" novalidate id="invoice-form">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_id">Invoice To</label>
                                    <select name="company_id" class="form-control select2" id="company_id">
                                        <option value="">Select</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="company-error"></div>

                                @error('company_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_label_id">Invoice Label</label>
                                    <select name="invoice_label_id" class="form-control select2" id="invoice_label_id">
                                        @foreach ($invoiceLabels as $label)
                                            <option value="{{ $label->id }}"
                                                {{ old('invoice_label_id') == $label->id ? 'selected' : '' }}>
                                                {{ $label->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('invoice_label_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="invoice_date">Invoice Date</label>
                                    <input type="date" class="form-control" name="invoice_date" id="invoice_date"
                                        value="{{ old('invoice_date') }}">
                                </div>
                                @error('invoice_date')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input type="date" class="form-control" name="due_date" id="due_date"
                                        value="{{ old('due_date') }}">
                                </div>
                                @error('due_date')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%">Item</th>
                                                <th style="width: 5%">Quantity</th>
                                                <th style="width: 15%">Unit Price</th>
                                                <th style="width: 10%">Tax</th>
                                                <th style="width: 10%">Discount</th>
                                                <th style="width: 15%">Total Price</th>
                                                <th class="text-right" style="width: 5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="item-list">
                                            <!-- input boxes will be added here -->
                                        </tbody>
                                    </table>

                                    <button type="button"
                                        class="btn btn-sm btn-primary waves-effect waves-light add-product" style="display: none;"
                                        data-bs-toggle="modal" data-bs-target="#selectProduct">
                                        <i class="ri-add-line align-middle me-2"></i> Add Product
                                    </button>
                                    @include('admin.invoice.product-selection')

                                </div>
                                {{-- /.table-responsive --}}
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <x-form.button />
                        <x-form.button-save-view />
                        <x-form.button-save-create-new />
                    </div>
                    {{-- /.card-footer --}}
                </form>
            </div>
            {{-- /.card --}}
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

        });
        // when company_id is selected show .add-product button
        $('#company_id').on('change', function() {
            const companyId = $(this).val();
            if (companyId) {
                $('.add-product').show();
            } else {
                $('.add-product').hide();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addProductButton = document.querySelector('.add-product');
            const modal = document.getElementById('selectProduct');
            const itemList = document.getElementById('item-list');

            // Add event listener to the "Add Product" button in the modal
            modal.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-item')) {
                    const productName = event.target.dataset.productName;
                    const productPrice = event.target.dataset.productPrice;

                    // Add a new row in the table
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>
                            <input type="text" class="form-control form-control-sm" name="product_name[]" value="${productName}">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm" name="quantity[]" min="1" value="1" oninput="calculateTotal(this)">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm" name="unit_price[]" oninput="calculateTotal(this)" value="${productPrice}">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm" name="tax[]" value="0" min="0" max="100" oninput="calculateTotal(this)">
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-sm" name="discount[]" value="0" min="0" oninput="calculateTotal(this)">
                                <div class="input-group-append">
                                    <select name="discount_type[]" class="form-control form-control-sm" onchange="calculateTotal(this)">
                                        <option value="percentage">%</option>
                                        <option value="amount">$</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm" name="total_price[]" value="${productPrice}" readonly>
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                        </td>
                    `;

                    // Add the new row to the table
                    itemList.appendChild(row);

                    // Close the modal
                    modal.querySelector('.btn-close').click();
                }
            });

            // Add event listener to remove a row when the "Remove" button is clicked
            itemList.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-row')) {
                    const row = event.target.closest('tr');
                    itemList.removeChild(row);
                }
            });
        });

        // Function to calculate total price for a row
        function calculateTotal(element) {
            const row = element.closest('tr');
            const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value);
            const unitPrice = parseFloat(row.querySelector('input[name="unit_price[]"]').value);
            const taxPercentage = parseFloat(row.querySelector('input[name="tax[]"]').value);
            const discount = parseFloat(row.querySelector('input[name="discount[]"]').value);
            const discountType = row.querySelector('select[name="discount_type[]"]').value;

            // Calculate subtotal (unit price * quantity)
            const subtotal = unitPrice * quantity;

            // Calculate discount amount based on the selected discount type
            let discountAmount = 0;
            if (discountType === 'percentage') {
                discountAmount = subtotal * (discount / 100);
            } else if (discountType === 'amount') {
                discountAmount = discount;
            }

            // Calculate tax amount as a percentage of the subtotal
            const taxAmount = subtotal * (taxPercentage / 100);

            // Calculate total price: subtotal + tax - discount
            const totalPrice = subtotal + taxAmount - discountAmount;

            // Set the total price in the input field
            row.querySelector('input[name="total_price[]"]').value = totalPrice.toFixed(2);
        }
    </script>
@endpush
