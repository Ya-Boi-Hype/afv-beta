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
        <div class="card-body">
          @approved
            Take a look at the different menus on the left. There you will find everything you need to start testing.<br>
            Thanks for your help,<hr>
            <i>The AFV Team</i>
          @endapproved
          @pending
            We have received your request to join the beta and will get in touch with you soon!</br>
            Many thanks,<hr>
            <i>The AFV Team</i>
          @endpending
          @hasnorequest
            Do you want the chance to try our new voice system?<hr>
            <a class="btn btn-primary" href="{{ route('request') }}">Sign me up!</a>
          @endhasnorequest
        </div>
        @endguest {{-- guest | else=>approved --}}
      </div>
    </div>
  </div>
        
  @auth
  @approved
  <div class="content flex-fill d-flex">
    <div class="col flex-fill d-flex">
      <div class="card card-body mb-4">
        <div class="content-header">
          <div class="card bg-success">
          <!--<div class="card bg-light">-->
            <div class="card-body">
              <b>LAST TEST:</b> <u>Wednesday, 4th September from 2300z to 0300z</u><br>
              <a href="https://new.bvartcc.com/" target="_blank"><i>Boston Virtual ARTCC</i></a> | Fly between KBOS, KBDL and KACK for the <b>last beta test</b> before release!
            </div>
          </div>
        </div>
        <div class="content flex-fill d-flex pb-4">
          <div class="container-fluid">
            <iframe src="https://discordapp.com/widget?id=551514966058860544&theme=light" class="h-100 w-100 discord-widget"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endapproved
  @pending
  <div class="content">
    <div class="col">
      <div class="card bg-success">
        <div class="card-body">
            <b>LAST TEST:</b> <u>Wednesday, 4th September from 2300z to 0300z</u><br>
            <a href="https://new.bvartcc.com/" target="_blank"><i>Boston Virtual ARTCC</i></a> | Fly between KBOS, KBDL and KACK for the <b>last beta test</b> before release!<hr>
          @canexpressavailability
          <form action="{{ route('request.available') }}" method="post">
            @csrf
            @method('PUT')
            <button class="btn btn-primary" action="submit">Express Availability</button>
          </form>
          @else
            <button class="btn btn-success disabled" disabled>Available</button>
          @endcanexpressavailability
        </div>
      </div>
    </div>
  </div>
  @endpending
  @endauth
@endsection