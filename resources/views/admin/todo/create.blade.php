@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Todo',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'My Todo List', 'link' => route('admin.todos.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.todos.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="title">Todo Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        value="{{ old('title') }}" required>
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="todo_label_id">Label</label>
                                    <select name="todo_label_id" class="form-control" id="todo_label_id">
                                        @foreach ($todoLabels as $label)
                                            <option value="{{ $label->id }}">{{ $label->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('todo_label_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reminder">Reminder?</label>
                                    <input type="datetime-local" class="form-control" name="reminder" id="reminder"
                                        value="{{ old('reminder') }}" min="{{ now()->format('Y-m-d\TH:i') }}"
                                        max="{{ now()->addDay(90)->format('Y-m-d\TH:i') }}">
                                </div>
                                @error('reminder')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="todo_details" id="todo_details" class="form-control" required>{!! old('todo_details') !!}</textarea>
                                </div>
                                @error('todo_details')
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
    <!--tinymce js-->
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- init js -->
    <script>
        // $(document).ready(function() {
        //     0 < $("#todo_details").length && tinymce.init({
        //         selector: "textarea#todo_details",
        //         height: 300,
        //         plugins: [
        //             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        //             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        //             "save table contextmenu directionality emoticons template paste textcolor"
        //         ],
        //         toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
        //         style_formats: [{
        //                 title: "Bold text",
        //                 inline: "b"
        //             },
        //             {
        //                 title: "Red text",
        //                 inline: "span",
        //                 styles: {
        //                     color: "#ff0000"
        //                 }
        //             }, {
        //                 title: "Red header",
        //                 block: "h1",
        //                 styles: {
        //                     color: "#ff0000"
        //                 }
        //             }, {
        //                 title: "Example 1",
        //                 inline: "span",
        //                 classes: "example1"
        //             }, {
        //                 title: "Example 2",
        //                 inline: "span",
        //                 classes: "example2"
        //             }, {
        //                 title: "Table styles"
        //             }, {
        //                 title: "Table row 1",
        //                 selector: "tr",
        //                 classes: "tablerow1"
        //             }
        //         ]
        //     })
        // });
    </script>
@endpush
