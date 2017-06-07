@extends('app')

@section('head_title', $article->title)
@section('head_keywords', $article->tags->pluck('name')->implode(',') . ',')
@section('head_description', $article->excerpt)

@section('content')
    <section class="jumbotron geopattern" data-pattern-id="{{ $article->slug }}">
        <div class="container article-banner">
            <h1 class="jumbotron-title">{{ $article->title }}</h1>
            <p class="jumbotron-desc">{{ $article->excerpt }}</p>
            <p class="jumbotron-meta pull-left">
                <span class="ion-calendar"></span> {{ $article->published_at->diffForHumans() }}
                &nbsp;&nbsp;<span class="ion-ios-folder"></span>
                <a href="/category/{{ $article->category->slug }}">{{ $article->category->name }}</a>
                &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
                @if ($article->tags)
                    @foreach($article->tags as $tag)
                        <a href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>&nbsp;
                    @endforeach
                @endif
            </p>
            <p class="pull-right operation-bar">
                @can('update', $article)
                    <a class="operation ion-edit text-light"
                       href="{{ route('article.edit', ['id' => $article->id]) }}"></a>
                @endcan
                @can('delete', $article)
                    <a class="operation ion-trash-a text-light swal-dialog-target"
                       data-url="{{ route('article.destroy', ['id' => $article->id]) }}" data-dialog-msg="确定删除这篇文章么?"
                       data-dialog-title=" " href="javascript:void(0)"></a>
                @endcan
            </p>
        </div>
    </section>
    <section class="container">
        <div class="row">
            <article class="article-content markdown-body">
                {!! $article->html_content !!}
                <br>
                <p>本文链接:
                    <a href="{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}">{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}</a>
                </p>
                <p class="well">
                    <b class="text-danger">声明</b>
                    <br>
                    <br>
                    在转载或修改本文后发布的文章中注明原文来源信息的前提下，允许进行转载该篇文章或经修改后发布且不用告知本文作者。
                </p>
            </article>

            <div class="share">
                <div class="share-bar"></div>
            </div>

            @if($article->ifShowComments())
                @include('widgets.comments',
                [
                    'comment_key'      => $article->slug,
                    'comment_title'    => $article->title,
                    'comment_url'      => route('article.show',$article->slug),
                    'commentable'      => $article,
                    'comments'         => isset($comments) ? $comments:[],
                    'redirect'         => request()->fullUrl(),
                    'commentable_type' => 'App\Article'
                ])
            @endif
        </div>
@endsection