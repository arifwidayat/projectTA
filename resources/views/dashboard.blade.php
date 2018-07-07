@extends('template.main')
@section('content')

            <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{\App\Models\Cuti::where('karyawan_id',auth()->id())->count()}}</h3>

              <p>Total Cuti</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{\App\Models\Cuti::where('karyawan_id',auth()->id())->where('status','approved')->count()}}</h3>

              <p>Total Approve</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{\App\Models\Cuti::where('karyawan_id',auth()->id())->where('status','waiting')->count()}}</h3>

              <p>Total Waiting</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
         <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{\App\Models\Cuti::where('karyawan_id',auth()->id())->where('status','rejected')->count()}}</h3>

              <p>Total Rejected</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>

        @if(auth()->user()->level=='hrd'||auth()->user()->level=='admin')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{\App\Models\Karyawan::count()}}</h3>
              <p>Total Pegawai</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          </div>
        </div>
        @endif
        <!-- ./col -->
      </div>
@endsection