@extends('layouts.master')
@section('title', 'xPilot')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h1 class="m-0 text-dark">xPilot (beta release)</h1>
        </div>
        <div class="card-body">
          <p>To use new voice as a xPilot user is very simple! Just download and run the installer available at the link below.</p>
          <p>This installer will create a new xPilot application and install a plugin to your XPlane folder. When connecting you can select any server, as it will always connect to the AFV Beta.<p>
          <p>To use xPilot, you will need to remove/disable other pilot clients like xSquawkBox, swift, etc... from your X-Plane plugins folder</p>
          <p class="text-danger"><b>Don't forget to go into the settings menu and calibrate your microphone by ensuring it is bouncing in the green bar when speaking!</b></p>
          <div class="w-100 text-center mb-3"><img src="{{ asset('images/demos/xpilot_settings.png') }}" class="img-fluid rounded"></div>
		      
          <a class="btn btn-primary" href="http://xpilot.clowd.io/installers/beta/xPilot-Setup-1.0.0.6.exe">Download xPilot for AFV</a>
          <a class="btn btn-primary" href="{{ asset('documents/xPilot_Quick_Start_Guide.pdf') }}" target="_blank">Quick Start Guide</a>
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