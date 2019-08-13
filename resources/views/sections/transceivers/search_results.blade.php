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
          @if($searchResults->total > 10)
          Showing the first <b>10 out of {{ $searchResults->total }} matches</b>
          @else
          <b>{{ $searchResults->total }} matches</b>
          @endif
      </div>
      <!-- /.card-header -->
      <div id="map" class="w-100" style="cursor:crosshair; min-height: 400px;"></div>
      <div class="card-body">
        <table id="results" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Alt MSL (m)</th>
              <th>Alt AGL (m)</th>
            </tr>
          </thead>
          @if ($searchResults->total > 0)
          <tbody>
            @foreach($searchResults->transceivers as $transceiver)
            <tr onclick="window.location='{{ route('transceivers.show', ['name' => $transceiver->name]) }}';">
              <td>{{ $transceiver->name }}</td>
              <td>{{ $transceiver->altMslM }}</td>
              <td>{{ $transceiver->altAglM }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Name</th>
              <th>Alt MSL (m)</th>
              <th>Alt AGL (m)</th>
            </tr>
          </tfoot>
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
  <!-- Map -->
  <script type="text/javascript">
    var map = L.map('map').setView([30.0, 0], 2);

    // Map Layers
    var streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map),
    satellite = L.tileLayer(
        'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
         attribution: '&copy; ' + '<a href="http://www.esri.com/">Esri</a>'
    });
    var maps = {"Streets": streets, "Satellite": satellite};
    L.control.layers(maps).addTo(map);

    // Marker Setup
    var search_results = @json($searchResults),
        transceivers = [],
        show_url = '{{ route("transceivers.show", ":name") }}';
    search_results.transceivers.forEach(function (transceiver) {
        var url = show_url.replace(':name', transceiver.name);
        var popup = '<a href="'+encodeURI(url)+'">';
        popup += '<b>' + transceiver.name + '</b>';
        popup += '</a>';
        transceivers.push(L.marker([transceiver.latDeg, transceiver.lonDeg]).addTo(map).bindPopup(popup));
        draw_range(transceiver);
    });
    map.fitBounds(L.featureGroup(transceivers).getBounds());

    function draw_range(transceiver){
      var RadiusMeters = 4193.18014745372 * Math.sqrt(transceiver.altMslM)
      L.circle([transceiver.latDeg, transceiver.lonDeg], {radius: RadiusMeters, fillOpacity: .3, color: '#ce6262'}).addTo(map).bindPopup('Range: '+String(RadiusMeters)+'m');
    }
  </script>

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
        "autoWidth": true,
      })
    });
  </script>
@endsection