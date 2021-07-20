@component('mail::message')
# Hey {{ $user->first_name }},

{{ $merchant->name }} has invited you to access their account with {{ config('app.name') }}.

Here are your login credentials:

@component('mail::panel')
<strong>Login:</strong> {{ $user->email }}
<br>
<strong>Password:</strong> {{ $password }}
@endcomponent

You'll be able to change your password at any time, from Account Settings.

@component('mail::button', ['url' => route('login')])
View Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
