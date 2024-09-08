@extends('mail.layouts.system')

@section('content')
    <h2>Daily Task Report</h2>

    <p>Here's the summary of tasks:</p>

    <ul>
        <li><strong>Total tasks:</strong> {{ $tasksSummary['total'] }}</li>
        <li><strong>Overdue tasks:</strong> {{ $tasksSummary['overdue'] }}</li>
        <li><strong>Not started tasks:</strong> {{ $tasksSummary['not_started'] }}</li>
        <li><strong>Started tasks:</strong> {{ $tasksSummary['started'] }}</li>
        <li><strong>Not completed tasks:</strong> {{ $tasksSummary['not_completed'] }}</li>
        <li><strong>Completed tasks:</strong> {{ $tasksSummary['completed'] }}</li>
    </ul>

    <a href="{{ $taskView }}">View Task List</a>
@endsection
