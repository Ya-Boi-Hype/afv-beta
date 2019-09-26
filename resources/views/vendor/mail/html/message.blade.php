@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => 'https://www.vatsim.net'])
            <img class="logo" src="{{asset('/images/logo_white.png')}}" data-skip-embed alt="VATSIM"/>
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            ©{{ date('Y') }} VATSIM Network - Design by Néstor Pérez
        @endcomponent
    @endslot
@endcomponent
