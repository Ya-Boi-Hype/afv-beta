@extends('layouts.master')
@section('title', 'Home')

@section('content')
  @hasDiscord
  <div class="content mt-3 flex-fill d-flex">
    <div class="col flex-fill d-flex">
      <div class="card card-body">
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
            <a href="{{ route('discord.create') }}" class="btn btn-primary">Login with Discord</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endhasDiscord
@endsection