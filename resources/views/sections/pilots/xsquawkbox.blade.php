@extends('layouts.master')
@section('title', 'xSquawkBox')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h1 class="m-0 text-dark">xSquawkBox</h1>
        </div>
        <div class="card-body">
          <p>xSquawkBox doesn't support AFV Voice natively. To use it with AFV, just download and install the standalone available below.
          Then, open your simulator and connect xSquawkBox like you normally would, but typing <b>afv-beta-fsd.vatsim.net</b> manually into the server box instead of selecting one from the dropdown.
          When connected, run the standalone client you installed and connect it too.</p>
		      <p class="text-danger"><b>Don't forget to go into the settings menu of the standalone and calibrate your microphone by ensuring it is bouncing in the green bar when speaking!</b></p>
          <div class="row mb-3">
            <div class="w-50 text-center my-auto"><img src="{{ asset('images/demos/xsb_server.png') }}" class="img-fluid rounded"></div>
            <div class="w-50 text-center my-auto"><img src="{{ asset('images/demos/standalone_settings_sm.png') }}" class="img-fluid rounded"></div>
          </div>
          <a class="btn btn-primary" href="{{ route('downloads.standalone') }}">Download Standalone Client</a>
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