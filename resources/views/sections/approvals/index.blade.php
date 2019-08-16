@extends('layouts.master')
@section('title', 'Approvals')

@section('head')
  @parent
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
<div class="content-header">
  <div class="col-12">

  </div>
  <div class="col-12">
    <div class="card w-100">
      <div class="card-header">
          <h1 class="text-dark">Approvals</h1>
      </div>
      <!-- /.card-header -->
        
      <div class="card-body">
        <div class="w-100">
          <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-thumbs-up"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><b>{{ $approved }} users have access to the beta</b></span>
              <div class="progress">
                <div class="progress-bar" style="width: {{ ($approved/$total)*100 }}%;"></div>
              </div>
              <div class="progress-info">
                {{ round(($approved/$total)*100) }}% of all requests submitted are approved
              </div>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="card">
          <div class="card-header">
            <h1>Search by Name</h1>
            <small>Only members that have submitted requests</small>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form class="form-horizontal text-center" action="{{ route('approvals.index') }}" method="get">
              <input class="form-control col-12 @error('name') is-invalid @enderror" type="text" name="name" placeholder="Flamingo Bellend" required>
              <button class="btn btn-success mt-3">Search</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card">
          <div class="card-header">
            <h1>Search by CID</h1>
            <small>Only members that have submitted requests</small>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form class="form-horizontal text-center" action="{{ route('approvals.index') }}" method="get">
              <input class="form-control col-12 @error('cid') is-invalid @enderror" type="number" name="cid" max="1500000" placeholder="1369273" required>
              <button class="btn btn-success mt-3">Search</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->    
  </div>
  <!-- /.col --> 
</div>
<!-- /.content-header --> 
@endsection

@section('scripts')
  @parent
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
  <!-- page script -->
  <script>
    $(function () {
      $("#results").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": true,
      })
    });
  </script>
@endsection