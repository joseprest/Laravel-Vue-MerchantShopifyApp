@component('mail::message')
# Hey {{ $user->first_name }},

Thank you for upgrading to the {{ $plan->name }} Plan.

<div class="features-list">
@if(count($features))
I wanted to send over some guides for the new features you now have access to:<br/>
<ul>
	@foreach($features as $feature)
	<li>
		<a href="{{ url('/') }}" target="_block">{{ $feature }}</a>
	</li>
	@endforeach
</ul>
@endif
</div>

@component('mail::button', ['url' => route('login')])
View Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
