<x-mail::message>
# Hi {{ $mailData['name'] }}

Your password has been reset. Please login with your new password.

Your new password **{{ $mailData['password'] }}**

@component('mail::button', ['url' => $mailData['url']])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>