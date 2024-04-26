@extends('components.layouts.app')

@section('content')

@include('partials.page-header', [
    'title' => 'Edit Product',
    'breadcrumbs' => [
        ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
        ['text' => 'Product List', 'link' => route('admin.products.index')],
        ['text' => 'Edit Product', 'link' => null],
    ],
])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $product->name) }}" required>
                                </div>
                                @error('name')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Product Price</label>
                                    <input type="text" name="price" class="form-control" id="price"
                                        value="{{ old('price', $product->price) }}" required>
                                </div>
                                @error('price')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="is_active">Product Status</label>
                                    <select name="is_active" class="form-control" id="is_active" required>
                                        <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Show</option>
                                        <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Hide</option>
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
                                    <textarea name="description" class="form-control" id="description">{{ old('description', $product->description) }}</textarea>
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
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="ri-save-line align-middle me-2"></i> Create
                        </button>
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
