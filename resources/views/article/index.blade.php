@extends('article.base')

@section('header')
    <title>{{ $jumbotron['title'] }}{{ $jumbotron['title'] === '麦肯先生' ? '' : ' - '.setting_config('title','') }}</title>
    <meta name="keywords" content=",{{ setting_config('seo_key') }}" />
    <meta name="description" content=",{{ setting_config('seo_desc') }}">
@endsection

@section('jumbotron-title')
    {{ $jumbotron['title'] }}
@endsection

@section('jumbotron-desc')
    {{ $jumbotron['desc'] }}
@endsection

@section('left')
    <ol class="article-list">
        @if(!empty($articles))
            @foreach($articles as $article)
                <li class="article-list-item">
                    <h3 class="article-list-name">
                        <a href="{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}" title="{{ $article->title }}">
                            {{ $article->title }}
                        </a>
                    </h3>
                    <p class="article-list-description">
                        {{ str_cut(convert_markdown($article->content),80) }}
                    </p>
                    <p class="article-list-meta">
                        <span class="ion-calendar"></span>{{ $article->published_at->diffForHumans() }} &nbsp;&nbsp;<span class="ion-ios-folder"></span><a href="/category/{{ $article->category->slug }}">{{ $article->category->name }}</a>
                        &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
                        @foreach($article->tags as $tag)
                            <a href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>&nbsp;
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
@endsection