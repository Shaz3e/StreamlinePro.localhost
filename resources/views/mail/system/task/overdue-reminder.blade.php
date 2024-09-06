@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>The task <strong>{{ $task->title }}</strong> was assigned to <strong>{{ $task->assignee->name }}</strong> is overdue
        on <strong>{{ $task->due_date->diffForHumans() }}</strong>
    </p>

    <a href="{{ $viewTask }}">View Task</a>
@endsection
