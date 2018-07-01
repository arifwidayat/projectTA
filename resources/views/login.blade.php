<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>

<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}">
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{!! asset('css/login.css') !!}">
<script type="text/javascript" src="{!! asset('js/login.js') !!}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('vendor/sweet-alert/sweet-alert.css') }}">
<script type="text/javascript" src="{{ asset('vendor/sweet-alert/sweetalert.min.js') }}"></script>

</head>
<body>
<div class="container">
    <div id="login-box">
            <h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>
        <div class="controls">
            <form method="POST" action="{{ url('login') }}">
                {{csrf_field()}}

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-default btn-flat btn-block">
                    Login
                </button>
            </form>
        </div><!-- /.controls -->
    </div><!-- /#login-box -->
</div><!-- /.container -->
<div id="particles-js"></div>
 @include('sweet::alert')
</body>
</html>