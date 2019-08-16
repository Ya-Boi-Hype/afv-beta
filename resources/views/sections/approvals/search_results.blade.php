@extends('layouts.master')
@section('title', 'Search Results')

@section('head')
  @parent
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
<div class="content-header">
  <div class="col">
    <div class="card w-100">
      <div class="card-header">
          <h1 class="m-0 text-dark">Search Results</h1>
          <b>{{ $searchResults->count() }} matches - Showing a maximum of 10</b>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="results" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>CID</th>
              <th>Name</th>
              <th>Approved</th>
            </tr>
          </thead>
          @if ($searchResults->count())
          <tbody>
            @foreach($searchResults->cursor() as $approval)
            <tr onclick="window.location='{{ route('approvals.edit', ['approval' => $approval]) }}';">
              <td class="w-25">{{ $approval->user_id }}</td>
              <td class="w-50">{{ ($approval->user->full_name) ?? 'Unknown' }}</td>
              <td class="w-25">{{ $approval->approved ? 'True' : 'False' }}</td>
            </tr>
            @endforeach
          </tbody>
          @endif
        </table>
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
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
      })
    });
  </script>
@endsection