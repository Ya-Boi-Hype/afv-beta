@component('mail::message')

@if (! empty($greeting))
# {{ $greeting }}
@else
Dear Audio for VATSIM Beta Applicant,
@endif

We are pleased to invite you to the Audio For VATSIM Beta testing team.
Please visit the Audio For VATSIM Website for further information on how to join.

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