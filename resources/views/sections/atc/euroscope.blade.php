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
            <p>To use Euroscope with AFV, you will need to download and install the standalone client and the Euroscope Update with NoVVL Shortcut available below.<br>
  <br>
			<a class="btn btn-primary mx-1 mt-1" href="{{ route('client.download') }}">Download Standalone Client</a>
			<a class="btn btn-primary mx-1 mt-1" href="http://afv-beta.vatsim.net/downloads/EuroScopeBeta32a21-With-AFV-Shortcut.zip">Download EuroScope Update and Shortcut</a>
			
  <br>
  
			Then, open Euroscope <b> via the shortcut in the beta download.</b> <BR><BR>In the connection window, set <b>afv-beta-fsd.vatsim.net</b> as the server and connect to it.<BR><BR>
            <BR><BR><strong>It is essential that you use the shortcut provided otherwise you will interfere with the live network.</strong><BR><BR>
            </b>. Finally, run the standalone client you previously installed and log in using your VATSIM Account.</p>
            
            <div class="row my-0">
              
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