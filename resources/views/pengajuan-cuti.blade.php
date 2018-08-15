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
              @php($level=auth()->user()->level)
            @forelse($cuti as $value)
              <tr>
                <td>{{$value->karyawan_id}}</td>
                <td>{{$value->no_pengajuan}}</td>
                <td>{{$value->tanggal_pengajuan}}</td>
                <td>{{$value->jenis_cuti}}</td>
                <td>{{$value->tanggal_mulai}}</td>
                <td>{{$value->tanggal_selesai}}</td>
                <td>{{$value->keterangan}}</td>
                <td>
                  @if($level=='kepala divisi'||$level=='admin')
                  <a class="btn btn-success btn-sm" href="{{url('pengajuan-cuti',[$value->id,'approved'])}}">Terima</a>
                  @endif
                  @if($level=='hrd'||$level=='admin')
                  <a class="btn btn-primary btn-sm" href="{{url('pengajuan-cuti',[$value->id,'verified'])}}">Verifikasi</a>
                  @endif
                  <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#tolak" onclick="return confirm('Are you sure want to reject this data?')">Tolak</button>

                    <div class="modal fade" tabindex="-1" role="dialog" id="tolak">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Keterangan</h4>
                          </div>
                        <form action="{{url('pengajuan-cuti',[$value->id,'rejected'])}}">
                          <div class="modal-body">
                              <textarea name="keterangan" class="form-control"></textarea>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                          </div>
                        </div>
                      </div>
                    </div>

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
            <tfoot>
              <tr>
                <td colspan="8">
                  {!! $cuti->links() !!}
                </td>
              </tr>
            </tfoot>
           </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection