@extends('app')

@section('header')
    <title></title>
    <meta name="keywords" content=",{{ setting_config('seo_key') }}" />
    <meta name="description" content=",{{ setting_config('seo_desc') }}">
@endsection

@section('content')

    <div class="jumbotron geopattern" data-pattern-id="{{ $keyword }}">
        <div class="container post-banner">
            <h1 class="jumbotron-title">关键词：{{ $keyword }}</h1>
        </div>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-sm-8">
                <ol class="post-list">
                    @if(!empty($posts))
                        @foreach($posts as $post)
                            <li class="post-list-item">
                                <h3 class="post-list-name">
                                    <a href="{{ route('post.show',array('id'=>$post->slug ? $post->slug : $post->id)) }}"
                                       title="{{ $post->title }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="post-list-description">
                                    {{ $post->excerpt }}
                                </p>
                                <p class="post-list-meta">
                                    <span class="ion-calendar"></span>{{ $post->published_at->diffForHumans() }}
                                    &nbsp;&nbsp;<span class="ion-ios-folder"></span><a
                                            href="/category/{{ $post->category->slug }}">{{ $post->category->name }}</a>
                                    &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
                                    @foreach($post->tags as $tag)
                                        <a href="/tag/{{ $tag->slug }}">{{ $tag->name }}</a>&nbsp;
                                    @endforeach
                                </p>

                            </li>
                        @endforeach
                    @endif
                </ol>
                <div class="pagination text-align">
                    <nav>
                        {!! $posts->links() !!}
                    </nav>
                </div>
            </div>
            <div class="col-sm-4">
                @include('partials.right')
            </div>
        </div>
@endsection