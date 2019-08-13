@extends('layouts.master')
@section('title', 'View Transceiver')

@section('head')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
@endsection

@section('content')
<div class="content-header">
  <div class="col">
    <div class="card w-100">
      <div class="card-header row">
        <h1 class="col-11 text-dark">Transceiver Details</h1>
        <a class="col-1 float-right btn btn-primary btn-sm" href="{{ route('transceivers.edit', ['id' => $transceiver->transceiverID]) }}">Edit</a>
      </div>
      <div id="map" class="w-100" style="cursor:crosshair; min-height: 400px;"></div>
      <div class="card-body row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tr>
                <th>Transceiver Name</th>
              </tr>
              <tr>
                <td>
                  {{ $transceiver->name }}
                </td>
              </tr>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-md-6">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tr>
                <th>Altitude MSL (m)</th>
              </tr>
              <tr>
                <td>
                  {{ $transceiver->altMslM }}
                </td>
              </tr>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-md-6">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <tr>
                <th>Altitude AGL (m)</th>
              </tr>
              <tr>
                <td>
                  {{ $transceiver->altAglM }}
                </td>
              </tr>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.col -->
        @admin
        <div class="col-12">
          <form class="text-center" id="deletion" method="POST" onsubmit="return confirm('Do you really want to delete this transceiver? There\'s no way back, young man...');" action="{{ route('transceivers.destroy', ['id' => $transceiver->transceiverID]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>
        </div>
        <!-- ./col -->
        @endadmin
      </div>
    </div>    
  </div>
</div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
      var transceiver = @json($transceiver);
      var map = L.map('map').setView([transceiver.latDeg, transceiver.lonDeg], 5);

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
      L.marker([transceiver.latDeg, transceiver.lonDeg]).addTo(map);
      var RadiusMeters = 4193.18014745372 * Math.sqrt(transceiver.altMslM)
      L.circle([transceiver.latDeg, transceiver.lonDeg], {radius: RadiusMeters, fillOpacity: .3, color: '#ce6262'}).addTo(map).bindPopup('Range: '+String(RadiusMeters)+'m');
    </script>
@endsection