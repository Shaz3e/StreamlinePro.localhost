<x-mail::message>
# Hi {{ $mailData['name'] }}

It looks like you requested for your password to be reset. If you did not request please ignore this email.

@component('mail::button', ['url' => $mailData['url']])
Reset Password
@endcomponent

Alternatively, you can use this link below to reset you password:
{{ $mailData['url'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>