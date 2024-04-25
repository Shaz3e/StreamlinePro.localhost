@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Create New Task',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'link' => route('admin.dashboard')],
            ['text' => 'Task List', 'link' => route('admin.tasks.index')],
            ['text' => 'Create', 'link' => null],
        ],
    ])

    {{-- Create Form --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.tasks.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Task Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        value="{{ old('title') }}" required>
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="task_status_id">Status</label>
                                    <select name="task_status_id" class="form-control" id="task_status_id">
                                        @foreach ($taskStatusList as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('task_status_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="assigned_to">Assign To</label>
                                    <select name="assigned_to" class="form-control" id="assigned_to">
                                        @foreach ($staffList as $staff)
                                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('assigned_to')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input type="datetime-local" class="form-control" name="due_date" id="due_date"
                                        value="{{ old('due_date') }}" min="{{ now()->format('Y-m-d\TH:i') }}">
                                </div>
                                @error('due_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" required>{!! old('description') !!}</textarea>
                                </div>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
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
    <!--tinymce js-->
    {{-- <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script> --}}

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
