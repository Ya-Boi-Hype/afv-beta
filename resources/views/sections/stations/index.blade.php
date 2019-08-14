@extends('layouts.master')
@section('title', 'Stations')

@section('head')
  @parent
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
@endsection

@section('content')
<!-- Main content -->
<div class="content-header flex-fill d-flex">
  <div class="col-12 flex-fill d-flex">
    <div class="card w-100 flex-fill d-flex">
      <div class="card-header">
        <h1 class="text-dark">Stations</h1>
        Select stations from the menu below
      </div>
      <div class="row flex-fill d-flex">
        <div class="card-body row flex-fill">
          <ul class="col-12 col-md-3 bg-light" id="data-tree">
            @foreach($searchResults->stations as $station)
            <li id="{{ $station->stationID }}">{{ $station->name }}
              @if(count($station->childStations))
              <ul>
                @include('sections.stations.handle_childs', ['childs' => $station->childStations])
              </ul>
              @endif
            </li>
            @endforeach
          </ul>
          <!-- /.data-tree -->
          <div class="col-12 col-md-9">
            <div id="map" class="h-100" style="cursor:crosshair; min-height: 400px;"></div>
          </div>
        </div>
        <!-- /.card-body col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.content-header -->
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
    $.fn.extend({
      treed: function (o) {
        var openedClass = 'fas fa-minus-circle';
        var closedClass = 'fas fa-plus-circle';
        if (typeof o != 'undefined'){
          if (typeof o.openedClass != 'undefined'){
          openedClass = o.openedClass;
          }
          if (typeof o.closedClass != 'undefined'){
          closedClass = o.closedClass;
          }
        };
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
          var branch = $(this); //li with children ul
          branch.prepend("<i class='indicator " + closedClass + "'></i>");
          branch.addClass('branch has-childs');
          branch.on('click', function (e) {
              if (this == e.target) {
                  var icon = $(this).children('i:first');
                  icon.toggleClass(openedClass + " " + closedClass);
                  $(this).children().children().toggle();
              }
          });
          branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
        tree.find('.branch .indicator').each(function(){
          $(this).on('click', function () {
              $(this).closest('li').click();
          });
        });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
          $(this).on('click', function (e) {
              $(this).closest('li').click();
              e.preventDefault();
          });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
          $(this).on('click', function (e) {
              $(this).closest('li').click();
              e.preventDefault();
          });
        });
      }
    });
    //Initialization of treeviews
    $('#data-tree').treed();
  </script>
  <script type="text/javascript">
    var map = L.map('map').setView([30, 0], 2);

    var stations = @json($searchResults->stations);

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

    function draw_range(){
      if(marker){
        if (ring) map.removeLayer(ring);
        var RadiusMeters = 4193.18014745372 * Math.sqrt($('#altMslM').val());
        ring = L.circle([marker.getLatLng().lat, marker.getLatLng().lng], {radius: RadiusMeters, fillOpacity: .3, color: '#ce6262'}).addTo(map);
      }
    }
  </script>
@endsection