<x-mail::message>
# Dear **{{ $staff->name }}**

Your account has been created. you can click the button below to login in to your account.<br>

Email: {{ $staff->email }}
Password: {{ request()->password }}


<x-mail::button :url="$url">
Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
