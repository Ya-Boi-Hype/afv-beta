@component('mail::message')
@if (! empty($greeting))
# {{ $greeting }}
@else
Dear Audio for VATSIM Tester,
@endif

We are writing to remind you of the largest AFV Beta test to date occurring on <b>Sunday, 25 August from 1300z - 1700z</b>. The test will be taking place within the UK division and many airports and centers throughout the United Kingdom will be staffed live from a conference center in Birmingham.

Our primary goal for this test is to ensure server and technology stability prior to release. To do so, we must stress the servers and need as many pilots as possible to participate. We hope to achieve upwards of 500 simultaneous connections during the test period.

As there have been many changes to AFV over the past week, please ensure that you check for updates to your version of vPilot and the AFV Standalone Client before connecting to the beta server. 

If you have not downloaded any software for AFV, please <b>ensure you download the beta versions from the AFV Beta Website</b> and not the production versions of the software from the developers websites. 

Also, please review the instructions for setting up and connecting to the beta found on the AFV Website. Most connection errors are due to missing a step in the connecting to VATSIM that can be addressed in the instructions. 

If you have any other questions, contact a member of the AFV team for assistance and we look forward to seeing you during the beta test on Sunday!
     
<hr>
@if (! empty($salutation))
<i>{{ $salutation }}</i>
@else
Best Regards,<br>
<i>The Audio For VATSIM Team</i>
@endif
@endcomponent