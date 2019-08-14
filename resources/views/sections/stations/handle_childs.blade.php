@foreach($childs as $child)
  <li id="{{ $station->stationID }}">{{ $child->name }}
    @if(count($child->childStations))
    <ul>
      @include('sections.stations.handle_childs', ['childs' => $child->childStations])
    </ul>
    @endif
  </li>
@endforeach