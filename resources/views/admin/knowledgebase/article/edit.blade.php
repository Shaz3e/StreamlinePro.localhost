@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Knowledgebase Article',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View Article List', 'link' => route('admin.knowledgebase.articles.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <form action="{{ route('admin.knowledgebase.articles.update', $article->id) }}" method="POST" class="needs-validation"
        novalidate enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            {{-- Article Editor --}}
            <div class="col-md-9">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Article Title" value="{{ old('title', $article->title) }}" required>
                                </div>
                                @error('title')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <input type="text" name="slug" id="slug" class="form-control form-control-sm"
                                        placeholder="article-slug-auto-generated" value="{{ old('slug', $article->slug) }}"
                                        required>
                                </div>
                                @error('slug')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <textarea name="content" class="form-control textEditor">{!! old('content', $article->content) !!}</textarea>
                                </div>
                                @error('slug')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                Created at: {{ $article->created_at }}
                            </div>
                            <div class="col-6 text-end">
                                Last Modified at: {{ $article->updated_at }}
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-footer --}}
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
            {{-- Sidebar --}}
            <div class="col-md-3">
                <div class="card" style="height: calc(100% - 15px)">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <select id="category_id" name="category_id" class="form-control select2" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <select id="author_id" name="author_id" class="form-control select2" required>
                                        <option value="">Select Author</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}"
                                                {{ old('author_id', $article->author_id) == $author->id ? 'selected' : '' }}>
                                                {{ $author->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('author_id')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <select id="is_published" name="is_published" class="form-control" required>
                                        <option value="1"
                                            {{ old('is_published', $article->is_published) == 1 ? 'selected' : '' }}>
                                            Publish
                                        </option>
                                        <option value="0"
                                            {{ old('is_published', $article->is_published) == 0 ? 'selected' : '' }}>Draft
                                        </option>
                                    </select>
                                </div>
                                @error('is_published')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-12 mb-3">
                                @if ($article->featured_image != null)
                                    <a href="{{ asset('storage/' . $article->featured_image) }}"
                                        class="image-popup-no-margins">
                                        <img src="{{ asset('storage/' . $article->featured_image) }}"
                                            alt="{{ $article->slug }}" class="img-fluid">
                                    </a>
                                @endif
                                <div class="form-group">
                                    <input type="file" name="featured_image" id="featured_image" class="form-control"
                                        id="customFile">
                                    <small class="d-block text-muted">Only JPG, JPEG, PNG, GIF, SVG with max 2MB file size
                                        allowed.</small>
                                </div>
                                @error('featured_image')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            {{-- /.col --}}
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}
                    <div class="card-footer">
                        <div class="d-grid">
                            <x-form.button class="mb-3 text-start" />
                            <x-form.button-save-view class="mb-3 text-start" />
                            <x-form.button-save-create-new class="mb-3 text-start" />
                        </div>
                    </div>
                </div>
                {{-- /.card --}}
            </div>
            {{-- /.col --}}
        </div>
        {{-- /.row --}}
    </form>
@endsection

@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Lightbox css -->
    <link href="{{ asset('assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <!-- Magnific Popup-->
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- lightbox init js-->
    <script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>
    <script>
        $(document).ready(function() {

            // Initialize select2
            $('.select2').select2();

            $('#title').on('input', function() {
                // Get the value from the title input
                var titleValue = $(this).val();

                // Generate a slug from the name
                var slugValue = generateSlug(titleValue);

                // Set the generated slug to the slug input
                $('#slug').val(slugValue);
            });

            // Article Editor
            0 < $(".textEditor").length && tinymce.init({
                selector: "textarea.textEditor",
                height: 500,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table directionality emoticons template paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                /* enable title field in the Image dialog*/
                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                /*
                    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                    images_upload_url: 'postAcceptor.php',
                    here we add custom filepicker only to Image dialog
                */
                file_picker_types: 'image',
                /* and here's our custom image picker*/
                file_picker_callback: (cb, value, meta) => {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];

                        const reader = new FileReader();
                        reader.addEventListener('load', () => {
                            /*
                            Note: Now we need to register the blob in TinyMCEs image blob
                            registry. In the next release this part hopefully won't be
                            necessary, as we are looking to handle it internally.
                            */
                            const id = 'blobid' + (new Date()).getTime();
                            const blobCache = tinymce.activeEditor.editorUpload
                                .blobCache;
                            const base64 = reader.result.split(',')[1];
                            const blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        });
                        reader.readAsDataURL(file);
                    });

                    input.click();
                },
                // content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
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
