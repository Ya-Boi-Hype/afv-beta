<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-blue navbar-dark">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    </li>
  </ul>
  <!-- #END# Left navbar links -->

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    @auth
    <li>
      <a class="nav-link" href="{{ route('auth.logout') }}">Logout <i class="fa fa-sign-out-alt pl-1"></i></a>
    </li>
    @else
    <li class="nav-item d-sm-inline-block">
      <a href="{{ route('auth.login') }}" class="nav-link">Login <i class="fa fa-sign-out-alt pl-1"></i></a>
    </li>
    @endauth
  </ul>
</nav>
<!-- /.navbar -->