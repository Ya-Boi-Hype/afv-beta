@component('mail::message')

@if (! empty($greeting))
# {{ $greeting }}
@else
Dear Audio for VATSIM Beta Applicant,
@endif

We are nearing the release of <i>Audio For VATSIM</i> and as such, would like to invite you to one of our last tests.

This test will take place on <u>Sunday, 29th September 2019</u>, with departures starting at 0800z. Our goal for this test is to find any potential bugs with HF transmissions.

The event airports are shown below. You can fly in between any of them:

|  DEP. Airports |   | ARR. Airports |
|:--------------:|:-:|:-------------:|
|      EFHK      |   |      CYQX     |
|      ESSA      |   |      CYYZ     |
|      ENGM      |   |      CYUL     |

For more information please login to the <i>Audio For VATSIM</i> website. Should you still have any other questions <b>after having read the documents available</b>, you may find our support channels there.

@component('mail::button', ['url' => route('home')])
More Information
@endcomponent

<hr>
@if (! empty($salutation))
<i>{{ $salutation }}</i>
@else
Best Regards,<br>
<i>The Audio For VATSIM Team</i>🦩
@endif

@endcomponent