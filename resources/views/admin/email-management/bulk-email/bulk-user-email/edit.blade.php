@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Email for All Users',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'View List', 'link' => route('admin.email-management.bulk-emails.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <form action="{{ route('admin.email-management.bulk-email-users.update', $bulkEmailUser) }}" method="POST"
        class="needs-validation" novalidate>
        @csrf
        @method('put')
        <div class="row">
            {{-- Build Email --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7 mb-3">
                                <div class="form-group">
                                    <label for="subject">Email Subject <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                        value="{{ old('subject', $bulkEmailUser->subject) }}" />
                                </div>
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="is_publish">Status <span class="text-danger">*</span></label>
                                    <select name="is_publish" class="form-control" id="is_publish">
                                        <option value="0" {{ old('is_publish', $bulkEmailUser->is_publish) == 0 ? 'selected' : '' }}>Draft</option>
                                        <option value="1" {{ old('is_publish', $bulkEmailUser->is_publish) == 1 ? 'selected' : '' }}>Publish</option>
                                    </select>
                                </div>
                                @error('is_publish')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="send_date">Publish On <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="send_date" id="send_date"
                                        value="{{ old('send_date',$bulkEmailUser->send_date) }}" min="{{ now()->format('Y-m-d\TH:i') }}">
                                </div>
                                <small class="text-muted">Email will be sent on this date time</small>
                                @error('send_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- /.col --}}
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="content">Email Content <span class="text-danger">*</span></label>
                                    <textarea name="content" id="content" class="form-control textEditor">{{ old('content', $bulkEmailUser->content) }}</textarea>
                                </div>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
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
            </div>
            {{-- /.col --}}
        </div>
        {{-- /.row --}}
    </form>
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
            });
        });
    </script>
@endpush
