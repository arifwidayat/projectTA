@extends('template.main')
@section('content')
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{$title}}</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
           <table class="table">
            <thead>
              <tr>
                <th>No Karyawan</th>
                <th>No Pengajuan</th>
                <th>Tanggal Pengajuan</th>
                <th>Jenis Cuti</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @php($jabatan=auth()->user()->jabatan)
            @forelse($cuti as $value)
              <tr>
                <td>{{$value->karyawan->no}}</td>
                <td>{{$value->no_pengajuan}}</td>
                <td>{{$value->tanggal_pengajuan}}</td>
                <td>{{$value->jenis_cuti}}</td>
                <td>{{$value->tanggal_mulai}}</td>
                <td>{{$value->tanggal_selesai}}</td>
                <td>{{$value->keterangan}}</td>
                <td>
                  @if($jabatan=='kepala divisi'||$jabatan=='admin')
                  <a class="btn btn-success btn-sm" href="{{url('pengajuan-cuti',[$value->id,'approved'])}}">Terima</a>
                  @endif
                  @if($jabatan=='hrd'||$jabatan=='admin')
                  <a class="btn btn-primary btn-sm" href="{{url('pengajuan-cuti',[$value->id,'verified'])}}">Verifikasi</a>
                  @endif
                  <a class="btn btn-danger btn-sm" href="{{url('pengajuan-cuti',[$value->id,'reject'])}}">Tolak</a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" align="center"><hr></td>
                <td style="vertical-align: middle;text-align: center">No Data</td>
                <td colspan="4" align="center"><hr></td>
              </tr>
            @endforelse
            </tbody>
           </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection