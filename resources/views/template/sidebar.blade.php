@php($level = auth()->user()->level)
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset(auth()->user()->photo)}}"  style="max-height: 45px;max-width: 45px;height: 45px;"  class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="white-space: normal;">{{auth()->user()->nama}}</p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="{{url('dashboard')}}"><i class="fa fa-book"></i> <span>Dashboard</span></a></li>
        <li><a href="{{route('pengajuan-cuti.index')}}"><i class="fa fa-book"></i> <span>Pengajuan Cuti</span></a></li>
        @if($level=='admin' || $level=='kepala divisi')
        <li><a href="{{url('pengajuan-cuti/approval')}}"><i class="fa fa-book"></i> <span>Approval Cuti</span></a></li>
        @endif
        @if($level=='admin' || $level=='hrd')
        <li><a href="{{url('pengajuan-cuti/verifikasi')}}"><i class="fa fa-book"></i> <span>Validasi Cuti</span></a></li>
        <li><a href="{{url('cuti')}}"><i class="fa fa-book"></i> <span>Laporan Cuti</span></a></li>
        @endif
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
            <li><a href="{{url('master/jatah-cuti')}}"><i class="fa fa-circle-o"></i> Jatah Cuti</a></li>
          </ul>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>