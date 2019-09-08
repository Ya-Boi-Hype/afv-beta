@extends('layouts.master')
@section('title', 'Home')

@section('content')
  @hasDiscord
  <div class="content mt-3 flex-fill d-flex">
    <div class="col flex-fill d-flex">
      <div class="card card-body">
        <div class="content-header">
          <div class="card bg-light">
            <div class="card-header">
              <h1 class="m-0 text-dark">My Preferred Name</h1>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="POST" action="{{ route('discord.update', auth()->user()->discord) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                  <div class="col-lg-12">
                    <select class="w-100 bg-light" name="account_mode">
                      <option value="0" {{ (auth()->user()->discord->mode == 0) ? 'selected' : null }}>{{ auth()->user()->discord->mode0 }}</option>
                      <option value="1" {{ (auth()->user()->discord->mode == 1) ? 'selected' : null }}>{{ auth()->user()->discord->mode1 }}</option>
                      <option value="2" {{ (auth()->user()->discord->mode == 2) ? 'selected' : null }}>{{ auth()->user()->discord->mode2 }}</option>
                    </select>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row mt-3 text-center">
                  <div class="col-12">
                    <button type="submit" class="btn btn-success w-100">Save</button>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </form>
            </div>
          </div>
        </div>
        <div class="content flex-fill d-flex">
          <div class="container-fluid">
            <iframe src="https://discordapp.com/widget?id=551514966058860544&theme=light" class="h-100 w-100 discord-widget"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="content-header">
    <div class="col">
      <div class="card w-100">
        <div class="card-header">
          <h1 class="m-0 text-dark">Link your Account</h1>
        </div>
        <div class="card-body">
          <p>Please, link your VATSIM and Discord Accounts before joining the <i>Audio For VATSIM</i> server.
          <div class="row col">
            <a href="{{ route('discord.login') }}" class="btn btn-primary">Login with Discord</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endhasDiscord
@endsection