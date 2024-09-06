@extends('mail.layouts.system')

@section('content')
    <h1>Dear {{ $task->assignee->name }}</h1>

    Your Task <strong>{{ $task->title }}</strong> will be due in <strong>{{ $task->due_date->diffForHumans() }}</strong>.
    Please
    complete it as soon as possible.

    <h2>{{ $task->title }}</h2>
    {!! $task->description !!}

    <ul>
        <li>Assigned To: {{ $task->assignee->name }}</li>
        <li>Created By: {{ $task->createdBy->name }}</li>
        <li>Due Date: {{ $task->due_date->diffForHumans() }}</li>
    </ul>

    <a href="{{ $viewTask }}">View Task</a>
@endsection
