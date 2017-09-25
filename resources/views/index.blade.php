<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title', setting('site_title'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

</head>

<body class="flat-blue">

<div id="app"></div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>