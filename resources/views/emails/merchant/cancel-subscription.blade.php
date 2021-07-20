@component('mail::message')
# Hey {{ $user->first_name }},

Thanks so much for giving {{ config('app.name') }} a try. I'm sorry that you didn't love the {{ $plan->name }} Plan.

I have a quick question that I hope you'll answer to help us make {{ config('app.name') }} better: why did you cancel?

Just reply to this email and let me know. I'd really appreciate it.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
