  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CUTI</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CUTI</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset(auth()->user()->photo)}}" style="height: 25px;width: 25px" class="user-image" alt="User Image">
              <span class="hidden-xs">{{auth()->user()->nama}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset(auth()->user()->photo)}}" style="height: 90px;width: 90px" class="img-circle" alt="User Image">

                <p>
                  {{auth()->user()->nama}}
                </p>
              </li>
             
              <li class="user-footer">
                <div align="center">
                  <a href="{{url('profile')}}" class="btn btn-flat btn-success pull-left">
                    Profile
                  </a>
                   <a class="btn btn-danger btn-flat pull-right" href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                  <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
