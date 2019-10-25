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
        @auth
        @facilityEngineer
        <li class="nav-item">
          <a href="{{ route('discord.index') }}" class="nav-link {{ Request::is('discord*') ? 'active' : null }}">
            <i class="nav-icon fab fa-discord"></i>
            <p>
              Discord
            </p>
          </a>
        </li>
        @endfacilityEngineer
        @managesPermissions
        <li class="nav-header">ADMIN</li>
        <li class="nav-item">
          <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : null }}">
            <i class="nav-icon fas fa-user-lock"></i>
            <p>
              Permissions
            </p>
          </a>
        </li>
        @endmanagesPermissions
        @endauth
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>