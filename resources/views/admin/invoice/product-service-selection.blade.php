<!-- Modal -->
<div class="modal fade" id="selectProductService" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="selectProductServiceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectProductServiceLabel">Add Product or Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productService as $productOrService)
                                <tr>
                                    <td>{{ $productOrService->name }}</td>
                                    <td>
                                        {{ $currency['symbol'] }}{{ $productOrService->price }}
                                        {{ $currency['name'] }}
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-sm btn-success waves-effect waves-light add-item"
                                            data-product-name="{{ $productOrService->name }}"
                                            data-product-price="{{ $productOrService->price }}">
                                            <i class="ri-add-line align-middle me-2"></i> Add
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
