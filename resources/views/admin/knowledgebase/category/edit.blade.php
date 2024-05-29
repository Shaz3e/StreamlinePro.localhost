@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Edit Knowledgebase Category',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View Category List', 'link' => route('admin.knowledgebase.categories.index')],
            ['text' => 'Edit', 'link' => null],
        ],
    ])

    {{-- Edit Form --}}
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.knowledgebase.categories.update', $category) }}" method="POST"
                class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $category->name) }}" required>
                                </div>
                                @error('name')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slug">Category Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        value="{{ old('slug', $category->slug) }}" required>
                                </div>
                                @error('slug')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <select id="is_active" name="is_active" class="form-control">
                                        <option value="1"
                                            {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
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
                </div>
                {{-- /.card --}}
            </form>
        </div>
        {{-- /.col --}}
    </div>
    {{-- /.row --}}
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#name').on('input', function() {
                // Get the value from the name input
                var nameValue = $(this).val();

                // Generate a slug from the name
                var slugValue = generateSlug(nameValue);

                // Set the generated slug to the slug input
                $('#slug').val(slugValue);
            });
        });

        function generateSlug(value) {
            // Ensure the slug adheres to the regex pattern
            var slug = value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '') // Remove unwanted characters
                .replace(/^\-+|\-+$/g, '') // Remove leading and trailing hyphens
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-') // Replace consecutive hyphens with a single hyphen
                .substring(0, 255); // Limit length to 255 characters (adjust as needed)

            return slug;
        }
    </script>
@endpush
