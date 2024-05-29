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
                                    <label for="task_label_id">Label</label>
                                    <select name="task_label_id" class="form-control select2" id="task_label_id">
                                        @foreach ($taskLabels as $label)
                                            <option value="{{ $label->id }}">{{ $label->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('task_label_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="assigned_to">Assign To</label>
                                    <select name="assigned_to" class="form-control" id="assigned_to">
                                        <option value="">Select</option>
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
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!--tinymce js-->
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- init js -->
    <script>
        $(document).ready(function() {
            // init select2
            $(".select2").select2();
            0 < $("#description").length && tinymce.init({
                selector: "textarea#description",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table directionality emoticons template paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
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

            // Search Staff
            $('#assigned_to').select2({
                ajax: {
                    url: '{{ route('admin.search.staff') }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    }
                },
                minimumInputLength: 3
            });
        });
    </script>
@endpush
