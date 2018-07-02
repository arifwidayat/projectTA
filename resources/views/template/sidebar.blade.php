  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('img/default-user.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="white-space: normal;">{{auth()->user()->nama}}</p>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="{{url('dashboard')}}"><i class="fa fa-book"></i> <span>Dashboard</span></a></li>
        @php($level = auth()->user()->level)
        @if($level == 'admin')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('master/karyawan')}}"><i class="fa fa-circle-o"></i> Karyawan</a></li>
            <li><a href="{{url('master/divisi')}}"><i class="fa fa-circle-o"></i> Divisi</a></li>
            <li><a href="{{url('master/jabatan')}}"><i class="fa fa-circle-o"></i> Jabatan</a></li>
            <li><a href="{{url('master/jatah-cuti')}}"><i class="fa fa-circle-o"></i> Jatah Cuti</a></li>
          </ul>
        </li>
        @endif
        <li><a href="{{url('pengajuan-cuti')}}"><i class="fa fa-book"></i> <span>Pengajuan Cuti</span></a></li>
        @if($level=='kepala divisi'||$level=='admin')
        <li><a href="{{url('pengajuan-cuti/approval')}}"><i class="fa fa-book"></i> <span>Approval Cuti</span></a></li>
        @endif
        @if($level=='hrd'||$level=='admin')
        <li><a href="{{url('pengajuan-cuti/verifikasi')}}"><i class="fa fa-book"></i> <span>Verif Cuti</span></a></li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>