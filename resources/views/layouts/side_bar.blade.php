<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">VSTS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">D Environ</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <ul class="nav nav-treeview">
              @if(Auth::user()->category == 'police')
              <li class="nav-item">
                <a href="police_admin"  class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              @endif
              @if(Auth::user()->category == 'bus_admin')
              <li class="nav-item">
                <a href="bus_admin" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              @endif
              @if(Auth::user()->category == 'system_admin')
              <li class="nav-item">
                <a href="system_admin" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              @endif
              @if(Auth::user()->category == 'public' || Auth::user()->category == 'police' || Auth::user()->category == 'bus_admin' || Auth::user()->category == 'system_admin')
              <li class="nav-item">
                <a href="/public" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Public Dashboard</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="/live_feed" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Live grid</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/buses" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Buses</p>
                </a>

              <li class="nav-item">
                <a href="/penalties" class="nav-link ">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Penalties</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/bus_details_form" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Add Bus details </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/devices" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Devices</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/location_finders" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Location Finders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/logout" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Logout</p>
                </a>
              </li>
            </ul>
          </li>
          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>