@extends('layouts.master')
@section('title', 'Home')

@section('content')
  <div class="content-header">
    <div class="col">
      <div class="card w-100">
        @guest
          <div class="card-header">
            <h1 class="m-0 text-dark">Welcome to the {{ config('app.name') }} Website!</h1>
          </div>
          <div class="card-body">
            In order to access the site, you must first <a href="{{ route('auth.login') }}">log in using your VATSIM Account</a>.
          </div>
        @else
          <div class="card-header">
            <h1 class="m-0 text-dark">Hi, {{ auth()->user()->name_first }}!</h1>
          </div>
          @hasnorequest
            <div class="card-body">
              Do you want the chance to try our new voice system?<hr>
              <a class="btn btn-primary" href="{{ route('request') }}">Sign me up!</a>
            </div>
          @else
            @approved
            <div class="card-body bg-danger py-2">
              Servers are currently down for upgrades
            </div>
            <div class="card-body pt-2">
              <p>Welcome to the <i>Audio For VATSIM</i> Beta Test.</p>
              <p>All testing is taking place on a standalone set of VATSIM servers which are not connected to the main network.</p>
			        <p>Take a look at the different menus on the left. There you will find everything you need to start testing as a pilot or a controller.</p>
			        <p>Feel free to join our discord by clicking connect on the bottom right where help will be available from the team.</p>
            @endapproved
            @pending
            <div class="card-body">
              <p>We have received your request to join the beta and will get in touch with you soon!</p>
            @endpending
              Thanks for your help and patience with this beta testing,<hr>
              <i>The AFV Team</i>
            </div>
          @endhasnorequest
        @endguest {{-- guest | else=>approved --}}
      </div>
    </div>
  </div>
@endsection