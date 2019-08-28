@extends('layouts.master')
@section('title', 'User Permissions')

@section('content')
<div class="content-header">
  <div class="col-12">

  </div>
  <div class="col-12">
    <div class="card w-100">
      <div class="card-header">
          <h1 class="text-dark">User Permissions</h1>
          <small>Enter user CID to manage its permissions</small>
      </div>
      <!-- /.card-header -->
        
      <div class="card-body">
        <form class="form-horizontal text-center" action="{{ route('permissions.index') }}" method="get">
          <input class="form-control col-12 @error('id') is-invalid @enderror" type="number" min="800000" max="1500000" name="id" placeholder="1369273" required>
          <button class="btn btn-success mt-3">Search</button>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->    
  </div>
  <!-- /.col --> 
</div>
<!-- /.content-header --> 
@endsection