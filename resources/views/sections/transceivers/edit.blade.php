@extends('layouts.master')
@section('title', 'Transceivers')

@section('head')
  @parent
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
@endsection

@section('content')
<!-- Main content -->
<div class="content-header">  
  <div class="card w-100">
    <div class="card-header">
      Select position on map
    </div>
    <!-- /.card-header -->
    <div id="map" class="w-100" style="cursor:crosshair; min-height: 400px;"></div>
    <div class="card-body">
      <form class="form-horizontal" method="POST" action="{{ route('transceivers.update', ['id' => $transceiver->transceiverID]) }}">
        @csrf
        @method('PATCH')
        @if(! $errors->has('lat') && ! $errors->has('lon') && old('lat') && old('lon'))
        <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
        <input type="hidden" id="lon" name="lon" value="{{ old('lon') }}">
        @else
        <input type="hidden" id="lat" name="lat" value="">
        <input type="hidden" id="lon" name="lon" value="">
        @endif
        <div class="row">
          @if($errors->has('lat') || $errors->has('lon'))
          <div class="col-12">
            <div class="alert alert-error">
              Invalid Lat./Lon. value
            </div>
          </div>
          @endif
          <div class="col-12">
            @if(! $errors->has('lat') && ! $errors->has('lon') && old('lat') && old('lon'))
            <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
            <input type="hidden" id="lon" name="lon" value="{{ old('lon') }}">
            @else
            <input type="hidden" id="lat" name="lat" value="{{ $transceiver->latDeg }}">
            <input type="hidden" id="lon" name="lon" value="{{ $transceiver->lonDeg }}">
            @endif
            <div class="row h-100">
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <tr>
                      <th>Transceiver Name</th>
                    </tr>
                    <tr>
                      <td>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="EGLL 1" value="{{ old('name') ?? $transceiver->name }}" required>
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
                        <input type="number" class="form-control @error('alt_msl') is-invalid @enderror" id="altMslM" name="alt_msl" placeholder="290" value="{{ old('alt_msl') ?? $transceiver->altMslM }}" min="0" required>
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
                        <input type="number" class="form-control @error('alt_agl') is-invalid @enderror" name="alt_agl" placeholder="90" value="{{ old('alt_agl') ?? $transceiver->altAglM }}" min="0" required>
                      </td>
                    </tr>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-success w-100">Update</button>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.col -->
</div>
<!-- /.content-header -->
@endsection

@section('scripts')
  @parent
  <!-- page script -->
  <script type="text/javascript">
    @if(! $errors->has('lat') && ! $errors->has('lon') && old('lat') && old('lon'))
    var map = L.map('map').setView([{{ old('lat') }}, {{ old('lon') }}], 5);
    @else
    var map = L.map('map').setView([{{ $transceiver->latDeg }}, {{ $transceiver->lonDeg }}], 5);
    @endif

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
    var marker,
        ring;
    @if(! $errors->has('lat') && ! $errors->has('lon') && old('lat') && old('lon'))
      marker = L.marker([{{ old('lat') }}, {{ old('lon') }}], {
          draggable: 'true'
      }).addTo(map);
      draw_range();
      marker.on('dragend', function(event) {
        marker.setLatLng(marker.getLatLng(), {
          draggable: 'true'
        });
        var position = marker.getLatLng().wrap();
        $('#lat').val(position.lat);
        $('#lon').val(position.lng);

        draw_range();
      });
    @else
      marker = L.marker([{{ $transceiver->latDeg }}, {{ $transceiver->lonDeg }}], {
          draggable: 'true'
      }).addTo(map);
      draw_range();
      marker.on('dragend', function(event) {
        marker.setLatLng(marker.getLatLng(), {
          draggable: 'true'
        });
        var position = marker.getLatLng().wrap();
        $('#lat').val(position.lat);
        $('#lon').val(position.lng);
        draw_range();
      });
    @endif

    // Listen for marker positioning
    map.on('click', function(e) {
        if(marker) map.removeLayer(marker);
        marker = L.marker(e.latlng, {
            draggable: 'true'
        }).addTo(map);

        var position = e.latlng.wrap();
        $('#lat').val(position.lat);
        $('#lon').val(position.lng);
        draw_range();

        marker.on('dragend', function(event) {
          marker.setLatLng(marker.getLatLng(), {
            draggable: 'true'
          });
          var position = marker.getLatLng().wrap();
          $('#lat').val(position.lat);
          $('#lon').val(position.lng);
          
          draw_range();
        });
    });
    
    $('#altMslM').on('input', function(e){
      draw_range();
    });

    function draw_range(){
      if(marker){
        if (ring) map.removeLayer(ring);
        var RadiusMeters = 4193.18014745372 * Math.sqrt($('#altMslM').val());
        ring = L.circle([marker.getLatLng().lat, marker.getLatLng().lng], {radius: RadiusMeters, fillOpacity: .3, color: '#ce6262'}).addTo(map);
      }
    }
</script>
@endsection