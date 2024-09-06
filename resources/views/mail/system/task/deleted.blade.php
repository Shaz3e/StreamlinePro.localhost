@extends('mail.layouts.system')

@section('content')
    <h2>System Notification</h2>
    <p>Task has been temporarily deleted and can be resotred anytime.</p>

    <h2>{{ $task->title }}</h2>
    {!! $task->description !!}

    <ul>
        <li>Assigned To: {{ $task->assignee->name }}</li>
        <li>Created By: {{ $task->createdBy->name }}</li>
        <li>Due Date: {{ $task->due_date->diffForHumans() }}</li>
    </ul>
@endsection
