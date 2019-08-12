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
              <input type="text" class="form-control @error('search') is-invalid @enderror" name="search" placeholder="EGLL 1" value="{{ old('search') }}" required>
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
                <div class="col-12 col-md-6">
                  <div class="text-sm">Select transceiver position on the map</div>
                  <div id="map" class="" style="cursor:crosshair; min-height: 400px;"></div>
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
                              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="EGLL 1" value="{{ old('name') }}" required>
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
                            <th>Altitude MSL</th>
                          </tr>
                          <tr>
                            <td>
                              <input type="number" class="form-control @error('alt_msl') is-invalid @enderror" name="alt_msl" placeholder="290" value="{{ old('alt_msl') }}" required>
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
                            <th>Altitude AGL</th>
                          </tr>
                          <tr>
                            <td>
                              <input type="number" class="form-control @error('alt_agl') is-invalid @enderror" name="alt_agl" placeholder="90" value="{{ old('alt_agl') }}" required>
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
    var marker;
    @if(! $errors->has('lat') && ! $errors->has('lon') && old('lat') && old('lon'))
      marker = L.marker([{{ old('lat') }}, {{ old('lon') }}], {
          draggable: 'true'
      }).addTo(map)
      marker.on('dragend', function(event) {
        marker.setLatLng(marker.getLatLng(), {
          draggable: 'true'
        });
        var position = marker.getLatLng().wrap();
        $('#lat').val(position.lat);
        $('#lon').val(position.lng);
      });
    @endif

    // Listen for marker positioning
    map.on('click', function(e) {
        if(marker) map.removeLayer(marker);
        marker = L.marker(e.latlng, {
            draggable: 'true'
        }).addTo(map);
        marker.on('dragend', function(event) {
          marker.setLatLng(marker.getLatLng(), {
            draggable: 'true'
          });
          var position = marker.getLatLng().wrap();
          $('#lat').val(position.lat);
          $('#lon').val(position.lng);
        });
        var position = e.latlng.wrap();
        $('#lat').val(position.lat);
        $('#lon').val(position.lng);
    });
</script>
@endsection