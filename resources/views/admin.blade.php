<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ setting_config('title','') }}</title>

	<link href="{{ asset('css/bootstrap-paper.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/css') }}">
	<link href="{{ asset('plugins/bootstrap-sweetalert/dist/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/js') }}"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	@include('partials.admin_nav')

    <div class="container">

	    <div class="row">

	        @yield('content')

	    </div>

	</div>

	<footer id="site-footer">
	    <div class="container">
	        <div class="copyright pull-left mobile-block">
	            © {{ date('Y') }}
	            <span>macken.me</span>
	        </div>
	    </div>
	</footer>

	<!-- Scripts -->
	<script src="{{ elixir('') }}"></script>
</body>
</html>
