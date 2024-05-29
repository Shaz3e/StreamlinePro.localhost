<x-mail::message>
# Dear {{ $supportTicket->user->name }}

{!! $supportTicketReply->message !!}

@component('mail::button', ['url' => route('support-tickets.show', $supportTicket->id)])
View Support Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>