@extends('app')

@section('content')

<div class="jumbotron @if (isset($jumbotron) && $jumbotron['title'] === '麦肯先生') home-jumbotron @else geopattern @endif" data-pattern-id="{{ $jumbotron['title'] or $article->title }}">
    <div class="container article-banner">
        <h1 class="jumbotron-title">@yield('jumbotron-title')</h1>
        <p class="jumbotron-desc">@yield('jumbotron-desc')</p>
        <p class="jumbotron-meta">@yield('jumbotron-meta')</p>
    </div>
</div>

<section class="container">
    <div class="row">
        <div class="col-sm-8">
            @yield('left')
        </div>
        <div class="col-sm-4">
            @include('partials.right')
        </div>
    </div>
</section>

@endsection