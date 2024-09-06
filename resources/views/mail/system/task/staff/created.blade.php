@extends('mail.layouts.system')

@section('content')
    <h1>You have a new task</h1>

    <h2>{{ $task->title }}</h2>
    {!! $task->description !!}

    <ul>
        <li>Assigned To: {{ $task->assignee->name }}</li>
        <li>Created By: {{ $task->createdBy->name }}</li>
        <li>Due Date: {{ $task->due_date->diffForHumans() }}</li>
    </ul>

    <a href="{{ $viewTask }}">View Task</a>
@endsection
