@extends('layouts.master')
@section('title', 'Stations')

@section('content')
<!-- Main content -->
<div class="content-header card">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview menu-{{ Request::is('clients/pilots*') ? 'open' : 'closed' }}">
        <a href="#" class="nav-link {{ Request::is('clients/pilots*') ? 'active' : null }}">
          <i class="nav-icon fa fa-plane"></i>
          <p>Pilot Clients<i class="right fa fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('pilots.vpilot') }}" class="nav-link {{ Request::is('clients/pilots/vpilot*') ? 'active' : null }}">
              <p>vPilot</p>
            </a>
          </li>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview menu-{{ Request::is('clients/pilots*') ? 'open' : 'closed' }}">
              <a href="#" class="nav-link {{ Request::is('clients/pilots*') ? 'active' : null }}">
                <i class="nav-icon fa fa-plane"></i>
                <p>Pilot Clients<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('pilots.vpilot') }}" class="nav-link {{ Request::is('clients/pilots/vpilot*') ? 'active' : null }}">
                    <p>vPilot</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('pilots.others') }}" class="nav-link {{ Request::is('clients/pilots/others*') ? 'active' : null }}">
                    <p>Others</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </ul>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('pilots.vpilot') }}" class="nav-link {{ Request::is('clients/pilots/vpilot*') ? 'active' : null }}">
              <p>vPilot</p>
            </a>
          </li>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview menu-{{ Request::is('clients/pilots*') ? 'open' : 'closed' }}">
              <a href="#" class="nav-link {{ Request::is('clients/pilots*') ? 'active' : null }}">
                <i class="nav-icon fa fa-plane"></i>
                <p>Pilot Clients<i class="right fa fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('pilots.vpilot') }}" class="nav-link {{ Request::is('clients/pilots/vpilot*') ? 'active' : null }}">
                    <p>vPilot</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('pilots.others') }}" class="nav-link {{ Request::is('clients/pilots/others*') ? 'active' : null }}">
                    <p>Others</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </ul>
      </li>
    </ul>
    <!-- /.treeview -->
</div>
<!-- /.content-header -->
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        $('ul').tree(options)
    </script>
@endsection