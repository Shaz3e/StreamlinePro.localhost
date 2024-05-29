<x-mail::message>
# Hi **{{ $task->createdBy->name }}**,

The task **{{ $task->title }}** was assigned to **{{ $task->assignee->name }}** is overdue on **{{ $task->due_date->diffForHumans() }}**.

<x-mail::button :url="$url">
Task List
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>