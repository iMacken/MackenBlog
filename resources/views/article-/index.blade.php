@extends('app')

@section('head_title', $jumbotron['title'])
@section('head_description', $jumbotron['description'])

@section('content')

    <div class="jumbotron geopattern" data-pattern-id="{{ $jumbotron['title'] }}">
        <div class="container post-banner">
            <h1 class="jumbotron-title">{{ $jumbotron['title'] }}</h1>
            <p class="jumbotron-desc">{{ $jumbotron['description'] }}</p>
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
                                    @if($post->getConfig('is_draft') === 'true') <span class="badge bg-warning">草稿</span> @endif
                                    @if($post->getConfig('is_original') === 'true') <span class="badge bg-success">原创</span> @endif
                                </h3>
                                <p class="post-list-description">
                                    {{ $post->excerpt }}
                                </p>
                                <p class="post-list-meta">
                                    @if($post->getConfig('is_draft') === 'false')
                                        <span class="ion-calendar"></span><span class="post-date" data-toggle="tooltip" data-placement="bottom" title="{{ $post->published_at->format('Y-m-d H:i') }}">{{ $post->published_at->diffForHumans() }}</span>
                                    @endif
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