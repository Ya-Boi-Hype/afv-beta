@extends('layouts.master')
@section('title', 'Search Results')

@section('head')
  @parent
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
  
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
<div class="content-header">
  <div class="col">
    <div class="card w-100">
      <div class="card-header">
        <h1 class="m-0 text-dark">Search Results</h1>
        Items <b>{{ $searchResults->firstItem() }}-{{ $searchResults->lastItem() }}</b> of {{ $searchResults->total() }}
      </div>
      <!-- /.card-header -->
      
      <div class="card-body">
        {{ $searchResults->links() }}
        <table id="results" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Transceivers</th>
              <th>Child Stations</th>
            </tr>
          </thead>
          @if ($searchResults->total() > 0)
          <tbody>
            @foreach($searchResults as $station)
            <tr onclick="window.location='{{ route('stations.show', ['id' => $station->stationID]) }}';">
              <td>{{ $station->name }}</td>
              <td>{{ count($station->transceiverIDs) }}</td>
              <td>{{ count($station->childStationIDs) }}</td>
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
        "ordering": false,
        "info": false,
        "autoWidth": true,
      })
    });
  </script>
@endsection