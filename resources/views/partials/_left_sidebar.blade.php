<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-0">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('favicon.ico') }}" alt="Logo" class="brand-image" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : null }}">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        @auth
        @approved
        <li class="nav-header">CLIENTS</li>
        <li class="nav-item has-treeview menu-{{ Request::is('clients/pilots*') ? 'open' : 'closed' }}">
          <span class="nav-link {{ Request::is('clients/pilots*') ? 'active' : null }}">
            <i class="nav-icon fa fa-plane"></i>
            <p>Pilot Clients<i class="right fa fa-angle-left"></i></p>
          </span>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('pilots.vpilot') }}" class="nav-link {{ Request::is('clients/pilots/vpilot*') ? 'active' : null }}">
                <p>vPilot</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pilots.xpilot') }}" class="nav-link {{ Request::is('clients/pilots/xpilot*') ? 'active' : null }}">
                <p>xPilot</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pilots.swift') }}" class="nav-link {{ Request::is('clients/pilots/swift*') ? 'active' : null }}">
                <p>swift</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pilots.xsb') }}" class="nav-link {{ Request::is('clients/pilots/xsb*') ? 'active' : null }}">
                <p>xSquawkBox</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview menu-{{ Request::is('clients/atc*') ? 'open' : 'closed' }}">
          <span class="nav-link {{ Request::is('clients/atc*') ? 'active' : null }}">
            <i class="nav-icon fas fa-satellite-dish"></i>
            <p>ATC Clients<i class="right fa fa-angle-left"></i></p>
          </span>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('atc.euroscope') }}" class="nav-link {{ Request::is('clients/atc/euroscope*') ? 'active' : null }}">
                <p>Euroscope</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('atc.vrc_vstars_veram') }}" class="nav-link {{ Request::is('clients/atc/vrc-vstars-veram*') ? 'active' : null }}">
                <p>VRC, vSTARS, vERAM</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview menu-{{ Request::is('clients/atis*') ? 'open' : 'closed' }}">
          <span class="nav-link {{ Request::is('clients/atis*') ? 'active' : null }}">
            <i class="nav-icon fas fa-cloud-sun"></i>
            <p>ATIS Clients<i class="right fa fa-angle-left"></i></p>
          </span>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('atis.euroscope') }}" class="nav-link {{ Request::is('clients/atis/euroscope*') ? 'active' : null }}">
                <p>Euroscope</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('atis.vatis') }}" class="nav-link {{ Request::is('clients/atis/vatis*') ? 'active' : null }}">
                <p>vATIS</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header">ISSUES</li>
        <li class="nav-item">
          <a href="/faq" class="nav-link">
            <i class="nav-icon fas fa-book-open"></i>
            <p>
              FAQ
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('issues') }}" class="nav-link {{ Request::is('issues*') ? 'active' : null }}">
            <i class="nav-icon fas fa-poop"></i>
            <p>
              Reporting Issues
            </p>
          </a>
        </li>
        @endapproved
        
        @hasSomePermission
        <li class="nav-header">ADMIN</li>
        @managesApprovals
        <li class="nav-item">
          <a href="{{ route('approvals.index') }}" class="nav-link {{ Request::is('approvals*') ? 'active' : null }}">
            <i class="nav-icon fas fa-user-check"></i>
            <p>
              Approvals
            </p>
          </a>
        </li>
        @endmanagesApprovals
        @managesPermissions
        <li class="nav-item">
          <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : null }}">
            <i class="nav-icon fas fa-user-lock"></i>
            <p>
              Permissions
            </p>
          </a>
        </li>
        @endmanagesPermissions
        @endhasSomePermission

        @endauth
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>