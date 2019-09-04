@extends('layouts.master')
@section('title', 'Swift')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h1 class="m-0 text-dark">swift</h1>
        </div>
        <div class="card-body">
            <p>swift currently does not natively support Audio For VATSIM, however with our handy little AFV Standalone client you can enjoy Audio For VATSIM with Swift!  <BR><BR> Firstly download the standalone client below and run the installer</p>
			
			     <a class="btn btn-primary" href="{{ route('client.download') }}">Download Standalone Client</a>
			
            <p class="mt-4">Once you have installed the standalone client, open your simulator and swift as usual and connect to <b>afv-beta-fsd.vatsim.net</b>.
			
			<br><br> If you are unsure on how to do this,in swift Click Settings in the Task Bar and click the blue "Servers" box. Here add the server address <b>afv-beta-fsd.vatsim.net.</b> <BR><BR>
When you are done it should look the same as the picture shown.
<BR><BR>
			<img src="{{ asset('images/demos/swiftsettings.png') }}" class="img-fluid rounded"><br><br>
            Then, open the <b>Audio For VATSIM</b> application which you installed earlier on, configure your settings and press 'Connect'.</p>
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