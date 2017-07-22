@extends('app')

@section('head_title', $jumbotron['title'])
@section('head_description', $jumbotron['description'])

@section('content')

    <div class="jumbotron geopattern" data-pattern-id="{{ $jumbotron['title'] }}">
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
                                    @if($article->getConfig('is_draft') === 'true') <span class="badge bg-warning">草稿</span> @endif
                                    @if($article->getConfig('is_original') === 'true') <span class="badge bg-success">原创</span> @endif
                                </h3>
                                <p class="article-list-description">
                                    {{ $article->excerpt }}
                                </p>
                                <p class="article-list-meta">
                                    @if($article->getConfig('is_draft') === 'false')
                                        <span class="ion-calendar"></span><span class="article-date" data-toggle="tooltip" data-placement="bottom" title="{{ $article->published_at->format('Y-m-d H:i') }}">{{ $article->published_at->diffForHumans() }}</span>
                                    @endif
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