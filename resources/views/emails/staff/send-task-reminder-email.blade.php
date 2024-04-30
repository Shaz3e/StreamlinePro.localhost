<x-mail::message>
# Hi **{{ $task->assignee->name }}**,

Your Task **{{ $task->title }}** will be due in **{{ $task->due_date->diffForHumans() }}**. Please complete it as soon as possible.

The body of your message.

<x-mail::button :url="$url">
Your Task
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
