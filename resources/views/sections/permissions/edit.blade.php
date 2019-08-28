@extends('layouts.master')
@section('title', "$id's Permissions")

@section('content')
<div class="content-header">
  <div class="col-12">

  </div>
  <div class="col-12">
    <div class="card w-100">
      <div class="card-header">
          <h1 class="text-dark">{{ $id }}'s Permissions</h1>
          <small>Select the permissions for this user below</small>
      </div>
      <!-- /.card-header -->
        
      <div class="card-body">
        <form class="form-horizontal text-center" action="{{ route('permissions.update', ['id' => $id]) }}" method="post">
          @csrf
          @method('PUT')
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              @forelse($allPermissions as $permission)
              <tr>
                <td><input type="checkbox" name="{{ $permission }}" id="{{ $permission }}" {{ in_array($permission, $hasPermissions) ? 'checked="checked" ' : null }}></td>
                <td class="text-left"><label class="mb-0" for="{{ $permission }}">{{ $permission }}</label></td>
              </tr>
              @empty
              <tr>
                <td>No permissions available</td>
              </tr>
              @endforelse
            </table>
          </div>
          <!-- /.table-responsive -->
          <button class="btn btn-success">Update</button>
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