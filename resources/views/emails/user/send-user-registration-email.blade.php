<x-mail::message>
# Hi **{{ $user->name }}**,

Your account has been created. you can click the button below to login in to your account.

<x-mail::button :url="$url">
Login Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
