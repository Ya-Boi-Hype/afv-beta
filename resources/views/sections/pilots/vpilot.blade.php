@extends('layouts.master')
@section('title', 'vPilot')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h1 class="m-0 text-dark">vPilot</h1>
        </div>
        <div class="card-body">
          <p>To use new voice as a vPilot user is very simple! <BR><BR>You just need to download and run the installer available at the link below.
          <BR><BR>This installer will create a new vPilot shortcut with <i>'AFV Beta'</i> in its name.<br>
          Use this shortcut to connect to the AFV server (you may select any server in vPilot's list).<BR><BR><strong>Don't forget to go into the settings menu and calibrate your microphone by ensuring it is bouncing in the green bar when speaking!</strong></p>
          <a class="btn btn-primary" href="http://vpilot.metacraft.com/Assets/Files/Installers/AfvBeta/vPilotAFVBeta-Setup-2.2.2.14.exe">Download vPilot for AFV</a>
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