@extends('template.main')
@section('content')
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{$title}}</h3>
          <br>
        </div>
        <div class="box-body">
        @if(!empty($sisacuti))
          <label>Sisa Cuti : {{$sisacuti->jumlah_cuti}}</label>
        @endif
        {!! form($form) !!}
        </div>
      </div>
      <!-- /.box -->
@endsection