# FAQs

---

- [General](#general)
- [ATC](#atc)
- [Pilots](#pilots)

<a name="general"></a>
## General
- <b>Will AFV work with my audio routing solution (e.g. Virtual Audio Cable)?</b>
    - As Audio for VATSIM is just a change to the codec you should still be able to use an audio routing program as you currently do. However the AFV team - will not provide support for them. 
- <b>Do I need a new microphone/headset?</b>
    - Not if it currently works with VATSIM. As voice quality is much higher, you may desire one so we can hear your beautiful voice more clearly!
- <b>Another user just asked me to adjust my microphone. What does that mean?</b>
    - Audio for VATSIM requires you to calibrate your microphone within the client you are using. Please go to the settings and adjust the microphone gain - slider until you can talk with most of your speech within the green band.
- <b>Why can’t I hear my voice back during the microphone calibration?</b>
    - Playing your voice back to yourself is actually not a very reliable way of setting audio levels. Ensuring your speech is peaking mostly in the green - area of the meter is by far the most reliable way to ensure consistent results.
- <b>Why are some pilots/controllers louder than others?</b>
    - AFV Simulates VHF ranges, so the further away from another pilot or controller you are, the less you may be able to hear them or the more static you - may hear in a transmissions. If you believe you are sufficiently in range, they have not set up their volume correctly. You could advise them to change it in the settings.
- <b>Are 8.33 kHz frequencies supported?</b>
    - Audio for VATSIM has the capability to support 8.33 kHz but unfortunately Simconnect for FS9, FSX, and P3D does not. Should that change in the future - we will certainly implement it!
- <b>I am an add-on developer and I want to integrate AFV into my software.</b>
    - Contact vpdev@vatsim.net
- <b>I love Audio for VATSIM and I want to do something in return.</b>
    - As with everything on VATSIM this is totally free to the users. Just enjoy the experience and if you really want to give something, consider donating -to one of the worldflight team charities- in November.

<a name="atc"></a>
## ATC
- <b>Which clients can I use to connect once AFV is launched?</b>
    - All currently supported clients are available but must be used with the AFV Client. Special shortcuts are available on the beta website so you don't interfere with the live network. <i>Soon™</i> ATC clients will be updated to use AFV without the extra client.
- <b>Do I need to update my sector files for AFV to work?</b>
    - No
- <b>The RDF-Plugin for Euroscope is no longer working, what should I do?</b>
    - The RDF Plugin Uses data from a source that doesn't work with AFV.
- <b>Do I need to bandbox multiple DEL/GND/TWR/APP Frequencies?</b>
    - Your Facility Engineer (FE) will know more, but there should be no need to transmit any differently than the way you already do pre-AFV.
- <b>I’ve logged in as GND/TWR/APP but aircraft seem really crackly/I can’t hear aircraft on the ground/on the ILS even though they should be well within range…</b>
    - The default visibility centre in your sector file may be somewhere other than your airport. Try forcing the radar visibility centre to your airport in order to update your transceiver location.
- <b>My Transceiver doesn’t cover the entire airspace I’m controlling, what should I do?</b>
    - Contact your local Facility Engineer (if you are a Facility Engineer who needs help, please reach out to the team leader).
- <b>How do I set my transceiver locations?</b>
    - This will depend on whether your local ARTCC/vACC has a Facility Engineer who has configured your airspace.
        - If the position you are logging on to has been pre-configured, your transceivers will be automatically downloaded from the AFV facility database and you will not be able to edit these -- this is to ensure consistent results for pilots and minimise the likelihood of frequency clashes with adjacent facilities.
        - If the position you are logging in to has not been pre-configured, your transceivers will automatically follow your controller client visibility points. You can add up to four additional ‘main’ transceivers by adding additional radar visibility points, and you can add smaller ‘top down’ transceivers for airports outside of the coverage of your main transceivers using the AFV ATC client.
- <b>What is the range of my radio transceivers?</b>
    - This will depend on the height of your transceiver, the height of the receiving aircraft and to a lesser extent whether your sector has been pre-configured by your local Facility Engineer or you are using controller client visibility centres. If you are using controller client visibility centres, your own transceiver height is set based on the type of facility you are connecting as.
        - All ‘top down’ transceivers added through the ATC client have the same specifications as DEL, GND and TWR transceivers.
        - The circles displayed on the AFV ATC client represent the range of each transceiver at sea level.

    | Position      | Max range at sea level (nm) | Max range at FL350 (nm) |
    | :             |   :                         |  :                      |
    | DEL, GND, TWR | 7                           | 236                     |
    | APP           | 12                          | 242                     |
    | CTR           | 42                          | 272                     |
    | FSS           | 48                          | 278                     |

<a name="pilots"></a>
## Pilots
- <b>Why can’t the controller hear me/why can't I transmit?</b>
    - Have you selected “COM1” in your radio panel? Are your batteries on? AFV Requires you to properly configure your radios!
        - Some addon aircraft may require to enable the MIC button on your COM1 panel as well
- <b>I am on a frequency with ATC, but why is it completely silent?</b>
    - Either no one is transmitting, or someone is transmitting, but you cannot hear it. Double check you are not actively transmitting or having an open mic and that your radio volume knob is turned up in the cockpit.
- <b>I’ve done all this and I still can not hear the controller and he still can not hear me.</b>
    - You may actually be in a radio dead zone where your aircraft is not in the range of any of ATC’s radio towers. Private message the controller to verify this and if you are, request further instructions from ATC over private message. As you climb your radio range will increase and once high enough your radio range will be within that of an ATC radio tower.
- <b>I can hear other pilots but not the controller, and the controller can’t hear me either. What’s going on?</b>
    - See above. It is possible that you may be too low to be in range of an ATC transceiver but you may still be in range of other nearby aircraft.
- <b>Why don’t I hear a blocking tone when I transmit over somebody else, or somebody else transmits over me?</b>
    - Radio is half-duplex, so you either receive or transmit. Anyone else on the frequency will hear the blocking tone if two or more people transmit at the same time. Please be mindful of this before speaking on frequency.
- <b>Why don’t I hear other people transmitting when I am?</b>
    - Aviation radios are half-duplex. You cannot receive at the same time as transmitting. Be mindful of this when you start to transmit and make sure you listen carefully to ensure you are not going to step on somebody else’s response to a transmission.
- <b>Why can I transmit on any frequency?</b>
    - Frequencies do not “open” or “close”. They are used or unused, and you can always transmit voice on any frequency. To figure out which frequency to transmit to, check the ATC in your area and which frequency they are using. If there is no ATC in your area, use UNICOM (122.800).
- <b>If all frequencies are available, why can’t I use the local frequency for my airport when no ATC is online?</b>
    - To ease the transition to Audio for VATSIM, we are sticking with the legacy UNICOM (122.800) to start. Moving to discrete (local) Common Traffic Advisory Frequencies is in our future plans.
- <b>Can I use the new voice codec to chat with my friends?</b>
    - As before, bandwidth and server capacity on the VATSIM network are donated resources. Do not use radios for anything other than ATC communication or traffic coordination when no ATC is online. Unauthorized use of the frequencies could lead to certificate actions under VATSIM Code of Conduct A1. 
