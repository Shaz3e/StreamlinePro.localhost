@extends('components.layouts.app')

@section('content')

@include('partials.page-header', [
    'title' => 'Edit',
    'breadcrumbs' => [
        ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
        ['text' => 'Product Service List', 'link' => route('admin.product-service.index')],
        ['text' => 'Edit Product', 'link' => null],
    ],
])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.product-service.update', $productService->id) }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $productService->name) }}" required>
                                </div>
                                @error('name')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" class="form-control" id="price"
                                        value="{{ old('price', $productService->price) }}" required>
                                </div>
                                @error('price')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control" id="type" required>
                                        <option value="product" {{ old('type', $productService) == 'product' ? 'selected' : '' }}>Product</option>
                                        <option value="service" {{ old('type', $productService) == 'service' ? 'selected' : '' }}>Service</option>
                                    </select>
                                </div>
                                @error('type')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <select name="is_active" class="form-control" id="is_active" required>
                                        <option value="1" {{ old('is_active', $productService->is_active) == 1 ? 'selected' : '' }}>Show</option>
                                        <option value="0" {{ old('is_active', $productService->is_active) == 0 ? 'selected' : '' }}>Hide</option>
                                    </select>
                                </div>
                                @error('is_active')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Product description</label>
                                    <textarea name="description" class="form-control" id="description">{{ old('description', $productService->description) }}</textarea>
                                </div>
                                @error('description')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
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
@endpush

@push('scripts')
@endpush
