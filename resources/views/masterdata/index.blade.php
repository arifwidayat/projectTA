@extends('template.main')
@section('css')
  <link href="{{asset('vendor/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
          @if(!empty($link))
            <a href="{{$link}}" type="button" class="btn btn-success" style="margin-bottom: 10px">
              <i class="fa fa-plus">Tambah</i></a>
          @endif

          @if(last(request()->segments())=='cuti')
          <div class="panel">
            <div class="panel-body">
                <div class="col-md-3">
                      <input type="text" class="form-control date-filter">
                  </div>
                  <div class="col-md-2">
                    <button class=" btn bg-maroon btn-filter">Filter</button>
                  </div>
            </div>
          </div>
          @endif
          {!! $dataTable->table() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
@endsection

@section('script')
  <script src="{!! asset('vendor/daterangepicker/moment.min.js') !!} "></script>
  <script src="{!! asset('vendor/daterangepicker/daterangepicker.js') !!} "></script>
{!! $dataTable->scripts() !!}
<script type="text/javascript">
var startdate, enddate;

      $('.date-filter').daterangepicker({
          locale: {
              format: 'DD/MM/YYYY'
          },
      }, function(start, end) {
        startdate = start;
        enddate = end;
      });

    $('.btn-filter').click(function(){
        url = location.origin+location.pathname+'?'
        
        url += 'date='+$('.date-filter').data('daterangepicker').startDate.format('DD/MM/YYYY')+"-"+$('.date-filter').data('daterangepicker').endDate.format('DD/MM/YYYY')
        
        window.location.href=url
      })

    @if(\Request::get("date"))
        var dateString = '{{ \Request::get("date") }}';
        var dateArray = dateString.split("-");
        $('.date-filter').data('daterangepicker').setStartDate(dateArray[0]);
        $('.date-filter').data('daterangepicker').setEndDate(dateArray[1]);
    @endif
    </script>
@endsection