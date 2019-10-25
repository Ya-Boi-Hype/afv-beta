@extends('layouts.master')
@section('title', 'Welcome')

@section('content')
  <div class="content-header">
    <div class="col">
      {{--<div class="card w-100 bg-info border border-success">
          <div class="card-header">
            <b>Next Event</b>: <u>HF (Oceanic) Testing</u>
          </div>
          <div class="card-body pt-0 pb-2">
            <ul class="my-2 pl-3">
              <li><b>Date:</b> Sunday, 29th September 2019 from 0800z onwards
              <li><b>From:</b> EFHK, ESSA and ENGM
              <li><b>To:</b> CYQX, CYYZ and CYUL
            </ul>
            @auth
            @pending
            @canexpressavailability
            <form class="form-horizontal" action="{{ route('request.available') }}" method="POST">
              @csrf
              @method('PUT')
              <button action="submit" class="btn btn-primary">Express Availability</button>
            </form>
            @else
            <button class="btn btn-success disabled" disabled>Availability Expressed - Please wait to be approved</button>
            @endcanexpressavailability
            @endpending
            @endauth
          </div>
      </div>--}}
      <div class="card w-100">
        @guest
          <div class="card-header">
            <h1 class="m-0 text-dark">Welcome to the {{ config('app.name') }} Control Panel!</h1>
          </div>
          <div class="card-body">
            In order to access the site, you must first <a href="{{ route('auth.login') }}">log in using your VATSIM Account</a>.
          </div>
        @else
          <div class="card-header">
            <h1 class="m-0 text-dark">Hi, {{ auth()->user()->name_first }}!</h1>
          </div>
          <div class="card-body pt-2">
            <p>Use the different menus on the left to navigate throughout the page.</p>
			      <p>Feel free to join our Discord server, where help will be available from the rest of the team.</p>
            Kind regards,<hr>
            <i>The AFV Team</i>
          </div>
        @endguest {{-- guest | else=>approved --}}
      </div>
    </div>
  </div>
@endsection
