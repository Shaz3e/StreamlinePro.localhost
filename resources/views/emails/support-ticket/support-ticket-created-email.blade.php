<x-mail::message>
@if ($supportTicket->user && $supportTicket->user->email === $recipient->email)
# Dear {{ $recipient->name }}
@elseif ($supportTicket->admin && $supportTicket->admin->email === $recipient->email)
# Dear {{ $recipient->name }}
@endif

The support ticket **{{ $supportTicket->title }}** was created on {{ $supportTicket->created_at->format('l, jS M Y') }}.

Ticket Number: **{{ $supportTicket->ticket_number }}**<br>
Ticket Status: **{{ $supportTicket->status->name}}**<br>
Ticket Priority: **{{ $supportTicket->priority->name}}**<br>

@if ($recipient instanceof \App\Models\Admin)
@component('mail::button', ['url' => route('admin.support-tickets.show', $supportTicket->id)])
View Support Ticket
@endcomponent
@else
@component('mail::button', ['url' => route('support-tickets.show', $supportTicket->id)])
View Support Ticket
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>