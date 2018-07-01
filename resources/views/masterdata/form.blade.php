@extends('template.main')
@section('content')
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
        {!! form($form) !!}
        </div>
      </div>
      <!-- /.box -->
@endsection