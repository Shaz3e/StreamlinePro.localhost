@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Promotion',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Promotion List', 'link' => route('admin.promotions.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.promotions.store') }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Promotion Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name') }}" required>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">Promotion Image</label>
                                    <input type="file" name="image" class="form-control" id="image"
                                        value="{{ old('image') }}" required>
                                </div>
                                <small class="text-muted">Upload PNG, JPG, JPEG with max 5MB file size.</small>
                                @error('image')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Promotion Description</label>
                                    <textarea name="description" class="form-control textEditor" id="description">{{ old('description') }}</textarea>
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
                                    <input type="date" class="form-control" name="start_date" id="start_date"
                                        value="{{ old('start_date') }}">
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
                                    <input type="date" class="form-control" name="end_date" id="end_date"
                                        value="{{ old('end_date') }}">
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
                                        <option value="0" {{ old('is_featured') == 0 ? 'selected' : '' }}>
                                            No
                                        </option>
                                        <option value="1" {{ old('is_featured') == 1 ? 'selected' : '' }}>
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
                                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>
                                            No
                                        </option>
                                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
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
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            0 < $(".textEditor").length && tinymce.init({
                selector: "textarea.textEditor",
                height: 500,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table directionality emoticons template paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [{
                        title: "Bold text",
                        inline: "b"
                    },
                    {
                        title: "Red text",
                        inline: "span",
                        styles: {
                            color: "#ff0000"
                        }
                    }, {
                        title: "Red header",
                        block: "h1",
                        styles: {
                            color: "#ff0000"
                        }
                    }, {
                        title: "Example 1",
                        inline: "span",
                        classes: "example1"
                    }, {
                        title: "Example 2",
                        inline: "span",
                        classes: "example2"
                    }, {
                        title: "Table styles"
                    }, {
                        title: "Table row 1",
                        selector: "tr",
                        classes: "tablerow1"
                    }
                ]
            })
        });
    </script>
@endpush
