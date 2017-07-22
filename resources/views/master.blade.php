<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title', setting('site_title'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/csstrap-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/checkbox3.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('js/datetimepicker/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/flat-blue.css') }}">


    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo-icon.png') }}" type="image/x-icon">

    <!-- CSS Fonts -->
    <link rel="stylesheet" href="{{ asset('fonts/admin/styles.css') }}">
    <script type="text/javascript" src="{{ asset('lib/js/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>

    @yield('css')

<!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!-- Few Dynamic Styles -->
    <style type="text/css">
        .flat-blue .side-menu .navbar-header, .widget .btn-primary, .widget .btn-primary:focus, .widget .btn-primary:hover, .widget .btn-primary:active, .widget .btn-primary.active, .widget .btn-primary:active:focus {
            background: {{ config('admin.primary_color','#22A7F0') }};
            border-color: {{ config('admin.primary_color','#22A7F0') }};
        }

        .breadcrumb a {
            color: {{ config('admin.primary_color','#22A7F0') }};
        }
    </style>

    @if(!empty(config('admin.additional_css')))<!-- Additional CSS -->
    @foreach(config('admin.additional_css') as $css)
        <link rel="stylesheet" type="text/css" href="{{ asset($css) }}">@endforeach
    @endif

    @yield('head')
</head>

<body class="flat-blue">

<div id="voyager-loader">
    <?php $admin_loader_img = setting('admin_loader', ''); ?>
    @if($admin_loader_img == '')
        <img src="{{ asset('images/logo-icon.png') }}" alt="Admin Loader">
    @else
        <img src="{{ image($admin_loader_img) }}" alt="Admin Loader">
    @endif
</div>

<?php
if ($user = Auth::user()) {
    $user_avatar = image($user->avatar, '/storage/users/default.png');
    if ((substr($user->avatar, 0, 7) == 'http://') || (substr($user->avatar, 0, 8) == 'https://')) {
        $user_avatar = $user->avatar;
    }
} else {
    $user_avatar = '/storage/users/default.png';
}

?>

<div class="app-container">
    <div class="fadetoblack visible-xs"></div>
    <div class="row content-container">
    @include('admin.dashboard.navbar')
    @include('admin.dashboard.sidebar')
    <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body padding-top">
                @yield('page_header')
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('admin.partials.app-footer')
<script>
    (function () {
        var appContainer = document.querySelector('.app-container'),
            sidebar = appContainer.querySelector('.side-menu'),
            navbar = appContainer.querySelector('nav.navbar.navbar-top'),
            loader = document.getElementById('voyager-loader'),
            anchor = document.getElementById('sidebar-anchor'),
            hamburgerMenu = document.querySelector('.hamburger'),
            sidebarTransition = sidebar.style.transition,
            navbarTransition = navbar.style.transition,
            containerTransition = appContainer.style.transition;

        sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
            appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

        if (window.localStorage && window.localStorage['admin.stickySidebar'] == 'true') {
            appContainer.className += ' expanded';
            loader.style.left = (sidebar.clientWidth / 2) + 'px';
            anchor.className += ' active';
            anchor.dataset.sticky = anchor.title;
            anchor.title = anchor.dataset.unstick;
            hamburgerMenu.className += ' is-active';
        }

        navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
        sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
        appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
    })();
</script>
<!-- Javascript Libs -->
<script type="text/javascript" src="{{ asset('lib/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/js/bootstrap-switch.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/js/jquery.matchHeight-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/js/perfect-scrollbar.jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<!-- Javascript -->
<script type="text/javascript" src="{{ asset('js/readmore.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/val.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/helpers.js') }}"></script>
@if(!empty(config('admin.additional_js')))<!-- Additional Javascript -->
@foreach(config('admin.additional_js') as $js)
    <script type="text/javascript" src="{{ asset($js) }}"></script>@endforeach
@endif

<script>
            @if(Session::has('alerts'))
    let alerts = {!! json_encode(Session::get('alerts')) !!};

    displayAlerts(alerts, toastr);
    @endif
</script>

{!! Toastr::message() !!}

@yield('javascript')
</body>
</html>