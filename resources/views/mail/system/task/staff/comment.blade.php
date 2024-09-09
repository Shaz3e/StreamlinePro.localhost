@extends('mail.layouts.system')

@section('content')
    <h3>{{ $taskComment->postedBy->name }} has responded on your task</h3>

    {!! $taskComment->message !!}

    <a href="{{ $viewTask }}">View & Reply</a>
@endsection
