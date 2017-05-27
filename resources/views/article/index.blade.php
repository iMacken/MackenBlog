@extends('app')

@section('header')
    <title>{{ $jumbotron['title'] }}</title>
    <meta name="keywords" content=""/>
    <meta name="description" content="">
@endsection

@section('content')

    <div class="jumbotron home-jumbotron">
        <div class="container article-banner">
            <h1 class="jumbotron-title">{{ $jumbotron['title'] }}</h1>
            <p class="jumbotron-desc">{{ $jumbotron['description'] }}</p>
        </div>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-sm-8">
                <ol class="article-list">
                    @if(!empty($articles))
                        @foreach($articles as $article)
                            <li class="article-list-item">
                                <h3 class="article-list-name">
                                    <a href="{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}"
                                       title="{{ $article->title }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p class="article-list-description">
                                    {{ str_cut(convert_markdown($article->content),80) }}
                                </p>
                                <p class="article-list-meta">
                                    <span class="ion-calendar"></span>{{ $article->published_at->diffForHumans() }}
                                    &nbsp;&nbsp;<span class="ion-ios-folder"></span><a
                                            href="/category/{{ $article->category->slug }}">{{ $article->category->name }}</a>
                                    &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
                                    @foreach($article->tags as $tag)
                                        <a href="/tag/{{ $tag->slug }}">{{ $tag->name }}</a>&nbsp;
                                    @endforeach
                                </p>

                            </li>
                        @endforeach
                    @endif
                </ol>
                <div class="pagination text-align">
                    <nav>
                        {!! $articles->links() !!}
                    </nav>
                </div>
            </div>
            <div class="col-sm-4">
                @include('partials.right')
            </div>
        </div>
@endsection