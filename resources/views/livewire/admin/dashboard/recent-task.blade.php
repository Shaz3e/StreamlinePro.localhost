<div class="row mb-3">
    {{-- Recent Tasks --}}
    <div class="col-12">
        <div class="card" style="height: calc(100% - 15px)">
            <div class="card-body">
                <h4 class="card-title">Recent Task</h4>
                <div class="table-resposnive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Assigned To</th>
                                <th>Started</th>
                                <th>Completed</th>
                                <th>Due At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr wire:key="{{ $task->id }}">
                                    <td>
                                        <a href="{{ route('admin.tasks.show', $task->id) }}">
                                            {{ $task->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.staff.show', $task->assignee->id) }}">
                                            {{ $task->assignee->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($task->is_started)
                                            {{ $task->start_time->format('d M Y H:i A') }}
                                        @else
                                            <small class="badge bg-info">Not Started</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$task->is_started && !$task->is_completed)
                                            ...
                                        @elseif($task->is_started && $task->is_completed)
                                            {{ $task->complete_time->format('d M Y H:i A') }}
                                        @else
                                            <small class="badge bg-info">Not Completed</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($task->due_date < now()->format('Y-m-d H:i:s') && $task->due_date !== null)
                                            <small class="text-danger">Task is Overdue</small>
                                        @elseif (!is_null($task->due_date))
                                            <small class="text-primary">
                                                {{ $task->due_date->format('d M Y H:i A') }}
                                            </small>
                                        @else
                                            <small class="text-muted">No Due Date</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- /.table-resposnive --}}
            </div>
            {{-- /.card-body --}}
        </div>
        {{-- /.card --}}
    </div>
    {{-- /.col --}}
</div>
{{-- /.row --}}