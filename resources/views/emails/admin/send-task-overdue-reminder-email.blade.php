<x-mail::message>

The task **{{ $task->title }}** is overdue on **{{ $task->due_date->diffForHumans() }}**.

<x-mail::button :url="$url">
View Task
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
