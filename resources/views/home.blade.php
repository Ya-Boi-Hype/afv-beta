@extends('layouts.master')
@section('title', 'Welcome')

@section('content')
  <div class="content-header">
    <div class="col">
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
            <p>Use the different menus on the left to navigate through the different pages.</p>
			      <p>Feel free to join our Discord server, where help will be available from the rest of the team.</p>
            Kind regards,<hr>
            <i>The AFV Team</i>
          </div>
        @endguest {{-- guest | else=>approved --}}
      </div>
    </div>
  </div>
@endsection
