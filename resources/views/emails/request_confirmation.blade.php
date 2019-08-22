@component('mail::message')

@if (! empty($greeting))
# {{ $greeting }}
@else
Dear Audio for VATSIM Beta Applicant,
@endif


Thanks for signing up for the voice beta.  We will be selecting people to load test the new voice infrastructure in stages.

You will receive further information when selected by email - thanks again for your support!

<hr>
@if (! empty($salutation))
<i>{{ $salutation }}</i>
@else
<i>The Audio For VATSIM Team</i>
@endif

@endcomponent