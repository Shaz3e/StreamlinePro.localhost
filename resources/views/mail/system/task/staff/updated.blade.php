@extends('mail.layouts.system')

@section('content')
    <h1>Task information changed</h1>

    <h2>{{ $task->title }}</h2>
    {!! $task->description !!}

    <ul>
        <li>Assigned To: {{ $task->assignee->name }}</li>
        <li>Created By: {{ $task->createdBy->name }}</li>
        <li>Due Date: {{ $task->due_date->diffForHumans() }}</li>
    </ul>

    <a href="{{ $viewTask }}">View Task</a>
@endsection
