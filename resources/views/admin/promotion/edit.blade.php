@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Edit New Promotion',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Promotion List', 'link' => route('admin.promotions.index')],
            ['text' => 'Edit', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" class="needs-validation"
                    novalidate enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Promotion Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $promotion->name) }}" required>
                                </div>
                                <small class="text-muted">For internal use only</small>
                                @error('name')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="image">Promotion Image</label>
                                    <input type="file" name="image" class="form-control" id="image"
                                        value="{{ old('image') }}">
                                </div>
                                <small class="text-muted">Upload PNG, JPG, JPEG with max 5MB file size.</small>
                                <div>
                                    <small class="text-danger">When you upload new image, old image will be deleted automatically.</small>
                                </div>
                                @error('image')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-2">
                                <a class="promotion-image-lightbox" href="{{ asset('storage/' . $promotion->image) }}">
                                    <img src="{{ asset('storage/' . $promotion->image) }}" class="img-fluid"
                                        loading="lazy" decoding="async" />
                                </a>
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Promotion description</label>
                                    <textarea name="description" class="form-control" id="description">{{ old('description', $promotion->description) }}</textarea>
                                </div>
                                <small class="text-muted">For internal use only</small>
                                @error('description')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                                        value="{{ old('start_date', $promotion->start_date) }}">
                                </div>
                                <small class="text-muted">Promotion Start Date</small>
                                @error('start_date')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                                        value="{{ old('end_date', $promotion->end_date) }}">
                                </div>
                                <small class="text-muted">Promotion End Date</small>
                                @error('end_date')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="is_featured">Featured Promotion</label>
                                    <select class="form-control" name="is_featured" id="is_featured">
                                        <option value="0" {{ old('is_featured', $promotion->is_featured) == 0 ? 'selected' : '' }}>
                                            No
                                        </option>
                                        <option value="1" {{ old('is_featured', $promotion->is_featured) == 1 ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                    </select>
                                </div>
                                <small class="text-muted">Featured images will appear first</small>
                                @error('is_featured')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="is_active">Enable/Disable Promotion</label>
                                    <select class="form-control" name="is_active" id="is_active">
                                        <option value="0" {{ old('is_active', $promotion->is_active) == 0 ? 'selected' : '' }}>
                                            No
                                        </option>
                                        <option value="1" {{ old('is_active', $promotion->is_active) == 1 ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                    </select>
                                </div>
                                <small class="text-muted">Handle visibility on promotion area</small>
                                @error('is_active')
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
    <link href="{{ asset('assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $(".promotion-image-lightbox").magnificPopup({
            type: "image",
            closeOnContentClick: !0,
            closeBtnInside: !1,
            fixedContentPos: !0,
            mainClass: "mfp-no-margins mfp-with-zoom",
            image: {
                verticalFit: !0
            },
            zoom: {
                enabled: !0,
                duration: 300
            }
        })
    </script>
@endpush
