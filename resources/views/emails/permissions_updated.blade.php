@component('mail::message')

# {{ $greeting }}

You have been granted the following permissions:
<ul>
@foreach($permissions as $permission)
<li>{{ $permission }}</li>
@endforeach
</ul>
     
<hr>
@if (! empty($salutation))
<i>{{ $salutation }}</i>
@else
Best Regards,<br>
<i>The Audio For VATSIM Team</i>
@endif

@endcomponent
