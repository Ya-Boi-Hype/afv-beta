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
            <p>To use Euroscope with AFV, you will need to download and install the standalone client available below. Then, open Euroscope as you would normally do. In the connection window, set <u>afv-beta-fsd.vatsim.net</u> as the server and connect to it.
            Open your communications dialog (the menu where you set all frequencies) and fill the voice server/room with garbage. <b>It is very important that you do this, as to not to disturb operations in the live network.
            <u>Not checking the VOI RCV/XMT boxes is NOT enough</u></b>. Finally, run the standalone client you previously installed and log in using your VATSIM Account.</p>
            <div class="w-100 text-center"><img src="{{ asset('images/demos/es_comms_full.png') }}" class="img-fluid rounded"></div>
            <div class="row my-0">
                <a class="btn btn-primary mx-1 mt-1" href="{{ route('client.download') }}">Download Standalone Client</a>
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