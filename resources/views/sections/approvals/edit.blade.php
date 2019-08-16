@extends('layouts.master')
@section('title', 'Edit Approval')


@section('content')
<div class="content-header">
  <div class="col-12">

  </div>
  <div class="col-12">
    <div class="card w-100">
      <div class="card-header">
          <h1 class="text-dark">Edit Approval</h1>
      </div>
      <!-- /.card-header -->
        
      <div class="card-body text-center">
            <table class="table table-striped table-bordered mb-3">
              <tr>
                <th class="col-3">CID</th>
                <th class="col-9">Name</th>
              </tr>
              <tr>
                <td class="col-3">{{ $approval->user_id }}</td>
                <td class="col-9">{{ ($approval->user->full_name) ?? 'Unknown' }}</td>
              </tr>
            </table>
            <!-- /.table-responsive -->

            <table class="table table-striped table-bordered mt-3">
              <tr>
                <th class="col-12">Status</th>
              </tr>
              <tr>
                <td class="col-12">{{ $approval->approved ? 'Approved on '.$approval->approved_at : 'Pending' }}</td>
              </tr>
            </table>

            <form class="mt-3" action="{{ route('approvals.update', ['approval' => $approval]) }}" method="post">
              @csrf
              @method('PUT')
              @if($approval->approved)
                  <button name="action" value="revoke" class="btn btn-danger" action="submit">Revoke</button>
              @else
                  <button name="action" value="approve" class="btn btn-success" action="submit">Approve</button>
              @endif
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