@component('mail::message')
@if (! empty($greeting))
# {{ $greeting }}
@else
Dear Audio for VATSIM Tester,
@endif

This <b>Sunday, 25th August</b> we have planned the largest Audio For VATSIM test to the date.

@component('mail::button', ['url' => route('home')])
Go to AFV Site
@endcomponent

Before reporting any issues or giving any feedback, please make sure that you follow the steps indicated in the 'Reporting Issues' section to do so.
     
<hr>
@if (! empty($salutation))
<i>{{ $salutation }}</i>
@else
<i>The Audio For VATSIM Team</i>
@endif
@endcomponent