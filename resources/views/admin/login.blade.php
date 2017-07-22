<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>{{ setting("title") }}</title>
    <link rel="stylesheet" href="{{ admin_asset('lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('css/login.css') }}">
    <style>
        body {
            background-image:url('{{ Admin::image( setting("admin_bg_image"), config('admin.assets_path') . "/images/bg.jpg" ) }}');
            background-color: {{ setting("admin_bg_color", "#FFFFFF" ) }};
        }
        .login-sidebar:after {
            background: linear-gradient(-135deg, {{config('admin.login.gradient_a','#ffffff')}}, {{config('admin.login.gradient_b','#ffffff')}});
            background: -webkit-linear-gradient(-135deg, {{config('admin.login.gradient_a','#ffffff')}}, {{config('admin.login.gradient_b','#ffffff')}});
        }
        .login-button, .bar:before, .bar:after{
            background:{{ config('admin.primary_color','#22A7F0') }};
        }

    </style>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="faded-bg animated"></div>
        <div class="hidden-xs col-sm-8 col-md-9">
            <div class="clearfix">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="logo-title-container">

                        <div class="copy animated fadeIn">
                            <h1>{{ setting('admin_title', 'Admin') }}</h1>
                            <p>{{ setting('admin_description', 'Welcome to Admin. The Missing Admin for Laravel') }}</p>
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-3 login-sidebar animated fadeInRightBig">

            <div class="login-container animated fadeInRightBig">

                <h2>@lang('Sign In Below'):</h2>

                <form action="{{ route('admin.login') }}" method="POST">
                {{ csrf_field() }}
                <div class="group">      
                  <input type="text" name="email" value="{{ old('email') }}" required>
                  <span class="highlight"></span>
                  <span class="bar"></span>
                  <label><i class="glyphicon glyphicon-user"></i><span class="span-input"> @lang('Email')</span></label>
                </div>

                <div class="group">      
                  <input type="password" name="password" required>
                  <span class="highlight"></span>
                  <span class="bar"></span>
                  <label><i class="glyphicon glyphicon-lock"></i><span class="span-input"> @lang('Password')</span></label>
                </div>

                <button type="submit" class="btn btn-block login-button">
                    <span class="signingin hidden"><span class="glyphicon glyphicon-refresh"></span> @lang('Logging in')...</span>
                    <span class="signin">@lang('Login')</span>
                </button>
               
              </form>

              @if(!$errors->isEmpty())
              <div class="alert alert-black">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach                
                </ul>
              </div>            
              @endif

            </div> <!-- .login-container -->
            
        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
</script>
</body>
</html>
