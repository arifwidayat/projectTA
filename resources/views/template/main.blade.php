<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi Pengajuan Cuti</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
@include('template.header')
@include('template.sidebar')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('content-title')
      </h1>
      <ol class="breadcrumb">
        @yield('breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@include('template.footer')
  
</div>
<!-- ./wrapper -->

<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('vendor/fastclick/lib/fastclick.js')}}"></script>
<script src="{{asset('js/adminlte.min.js')}}"></script>
<script src="{{asset('js/demo.js')}}"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
