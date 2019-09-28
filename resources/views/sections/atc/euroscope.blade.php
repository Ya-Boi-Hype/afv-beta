@extends('layouts.master')
@section('title', 'Euroscope')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h1 class="m-0 text-dark">Euroscope</h1>
        </div>
        <div class="card-body">
          <p>To use Euroscope with AFV, you will need to download and install the latest Euroscope Beta and the standalone client. You will also need to download the shortcut available below, as you <u>MUST</u> use it to open Euroscope whenever you want to connect to new voice.
          Then, download the AFV plugin available from the link below, open Euroscope using the shortcut you previously downloaded and load it in. Now, in the connection window, set <b>afv-beta-fsd.vatsim.net</b> as the server and connect to it. Finally, connect using the standalone.</p>
          
          <p class="text-danger"><b>Don't forget to go into the settings menu of the standalone and calibrate your microphone by ensuring it is bouncing in the green bar when speaking!</b></p>

          <div class="w-100 text-center my-3"><img src="{{ asset('images/demos/standalone_settings.png') }}" class="img-fluid rounded"></div>
          <div class="row mt-0">
            <a class="btn btn-primary mx-1 mt-1" href="https://www.euroscope.hu/install/EuroScopeBeta32a22.zip">Download Euroscope Beta 3.2a (r22)</a>
            <a class="btn btn-primary mx-1 mt-1" href="{{ route('downloads.standalone') }}">Download Standalone Client</a>
            <a class="btn btn-primary mx-1 mt-1" href="{{ route('downloads.euroscope') }}">Download AFV Shortcut</a>
            <a class="btn btn-primary mx-1 mt-1" href="https://github.com/AndyTWF/afv-euroscope-bridge/releases/latest/download/AfvEuroScopeBridge.dll">Download Plugin</a>
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@endsection