@extends('admin.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ admin_asset('css/ga-embed.css') }}">
@stop

@section('content')
    <div class="page-content">
        @include('admin.alerts')
        @include('admin.dimmers')

    </div>
@stop

@section('javascript')

@stop
