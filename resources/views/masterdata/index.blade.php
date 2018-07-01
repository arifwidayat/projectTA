@extends('template.main')
@section('content')
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <a href="{{$link}}" type="button" class="btn btn-success" style="margin-bottom: 10px">
              <i class="fa fa-plus">Tambah</i></a>
          {!! $dataTable->table() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection

@section('script')
{!! $dataTable->scripts() !!}
@endsection