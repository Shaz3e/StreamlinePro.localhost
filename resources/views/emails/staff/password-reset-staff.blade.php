<x-mail::message>
# Dear **{{ $staff->name }}**

Your password has been rest. Please click the link below to set your new password.

<x-mail::button :url="$url">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
