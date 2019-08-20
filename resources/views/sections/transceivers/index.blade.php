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
  <div class="col">
    <div class="card w-100">
      <div class="card-header">
        <h1 class="text-dark">Transceivers</h1>
      </div>
      <!-- /.card-header -->
      <div class="card-body row">    
        <div class="col-12 card">
          <div class="card-header">
            Search
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form class="form-horizontal" method="GET" action="{{ route('transceivers.index') }}">
              <input type="text" class="form-control text-uppercase @error('search') is-invalid @enderror" name="search" placeholder="CZQX_VATCAN_GANDER_VHF" value="{{ old('search') }}">
              <button type="submit" class="btn btn-success mt-3 w-100">Search</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.col -->

        <div class="col-12 card">
          <div class="card-header">
            Create
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('transceivers.store') }}">
              @csrf
              <div class="row">
                @if($errors->has('lat') || $errors->has('lon'))
                <div class="col-12">
                  <div class="alert alert-error">
                    Invalid Lat./Lon. value
                  </div>
                </div>
                @endif
                <div class="col-12">
                  <div class="text-sm">Select transceiver position on the map</div>
                </div>
                <div class="col-12 col-md-6">
                  <div id="map" class="" style="cursor:crosshair; min-height: 350px;"></div>
                  <select class="w-100 bg-light" id="view_range">
                    <option value="GND">Radio Range</option>
                    <option value="FL050">FL050 Range</option>
                    <option value="FL100">FL100 Range</option>
                    <option value="FL150">FL150 Range</option>
                    <option value="FL350">FL350 Range</option>
                  </select> 
                </div>
                <div class="col-12 col-md-6 mt-3 mt-md-auto">
                  @if(! $errors->has('lat') && ! $errors->has('lon') && old('lat') && old('lon'))
                  <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                  <input type="hidden" id="lon" name="lon" value="{{ old('lon') }}">
                  @else
                  <input type="hidden" id="lat" name="lat" value="">
                  <input type="hidden" id="lon" name="lon" value="">
                  @endif
                  <div class="row h-100">
                    <div class="col-12 my-auto">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <tr>
                            <th>Transceiver Name</th>
                          </tr>
                          <tr>
                            <td>
                              <input type="text" class="form-control text-uppercase @error('name') is-invalid @enderror" name="name" placeholder="CZQX_VATCAN_GANDER_VHF" value="{{ old('name') }}" required>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 my-auto">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <tr>
                            <th>Altitude MSL (m)</th>
                          </tr>
                          <tr>
                            <td>
                              <input type="number" class="form-control @error('alt_msl') is-invalid @enderror" id="altMslM" name="alt_msl" placeholder="290" value="{{ old('alt_msl') }}" min="0" required>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 my-auto">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <tr>
                            <th>Altitude AGL (m)</th>
                          </tr>
                          <tr>
                            <td>
                              <input type="number" class="form-control @error('alt_agl') is-invalid @enderror" name="alt_agl" placeholder="90" value="{{ old('alt_agl') }}" min="0" required>
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
              </div>
              <!-- /.row -->
              <div class="row mt-3 text-center">
                <div class="col-12">
                  <button type="submit" class="btn btn-success w-100">Create</button>
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
  <!-- page script -->
  <script type="text/javascript">
    var map = L.map('map').setView([30, 0], 2);

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
    
    $('#altMslM').on('input', draw_range);
    $('#view_range').on('change', draw_range);

    function draw_range(){
      if(marker){
        if (ring) map.removeLayer(ring);
        var RadiusMeters = 4193.18014745372 * Math.sqrt($('#altMslM').val()) + 4193.18014745372 * Math.sqrt(get_selected_range_height());
        ring = L.circle([marker.getLatLng().lat, marker.getLatLng().lng], {radius: RadiusMeters, fillOpacity: .3, color: '#ce6262', weight: 1}).addTo(map);
      }
    }

    function get_selected_range_height(){
      switch($('#view_range').val()) {
        case 'GND':
          return 0;
        case 'FL050':
          return 1524;
        case 'FL100':
          return 3048;
        case 'FL150':
          return 4572;
        case 'FL350':
          return 10668;
        default:
          return 0;
      }
    }
  </script>
@endsection