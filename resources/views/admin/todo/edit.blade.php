@extends('components.layouts.app')

@section('content')
    @include('partials.page-header', [
        'title' => 'Edit Todo',
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
                <form action="{{ route('admin.todos.update', $todo->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="title">Todo Title</label>
                                    <input type="text" name="title" class="form-control" id="title" value="{{ $todo->title }}" required>
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="todo_status_id">Status</label>
                                    <select name="todo_status_id" class="form-control" id="todo_status_id">
                                        @foreach ($todoStatus as $status)
                                            <option value="{{ $status->id }}" {{ $todo->todo_status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('todo_status_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reminder">Reminder?</label>
                                    <input type="datetime-local" class="form-control" name="reminder" id="reminder" value="{{ $todo->reminder }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}"
                                    max="{{ now()->addDay(90)->format('Y-m-d\TH:i') }}">
                                </div>
                                @error('reminder')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="todo_details">Details</label>
                                    <textarea name="todo_details" required>
                                        {{ $todo->todo_details }}
                                    </textarea>
                                </div>
                                @error('message')
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
@endpush
