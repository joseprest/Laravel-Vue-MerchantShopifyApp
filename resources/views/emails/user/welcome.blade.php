@component('mail::message')
# Hey {{ $user->first_name }},

Thank you for signing up for {{ config('app.name') }}!

We're excited to help you grow your business by offering your customers a great features.

Getting started only takes a few minutes.

@component('mail::button', ['url' => route('login'), 'color' => 'blue'])
Get Started
@endcomponent

If you have any questions, feel free to reply to this email and our team will respond as soon as they can.

Thank you,<br>
{{ config('app.name') }} Team
@endcomponent
