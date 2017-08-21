@extends('master')

@section('content')
    <section class="jumbotron geopattern" data-pattern-id="{{ $post->slug }}">
        <div class="container post-banner">
            <h1 class="jumbotron-title">{{ $post->title }}</h1>
            <p class="jumbotron-desc">{{ $post->excerpt }}</p>
            <p class="jumbotron-meta pull-left">
                @if(!(bool)$post->getConfig('is_draft'))
                    <span class="ion-calendar"></span> {{ $post->published_at ? $post->published_at->diffForHumans() : $post->created_at->diffForHumans() }}
                @endif
                &nbsp;&nbsp;<span class="ion-ios-folder"></span>
                <a href="/category/{{ $post->category->slug }}">{{ $post->category->name }}</a>
                &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
                @if ($post->tags)
                    @foreach($post->tags as $tag)
                        <a href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>&nbsp;
                    @endforeach
                @endif
                    <span class="ion-eye"></span>
                {{ $post->view_count }}
            </p>
            <p class="pull-right operation-bar">
                @can('update', $post)
                    <a class="operation ion-edit text-light"
                       href="{{ route('post.edit', ['id' => $post->id]) }}"></a>
                @endcan
                @can('delete', $post)
                    <a class="operation ion-trash-a text-light swal-dialog-target"
                       data-url="{{ route('post.destroy', ['id' => $post->id]) }}" data-dialog-msg="确定删除这篇文章么?"
                       data-dialog-title=" " href="javascript:void(0)"></a>
                @endcan
            </p>
        </div>
    </section>
    <section class="container">
        <div class="row">
            <post class="post-content markdown-body">
                {!! $post->html_content !!}
                <br>
                <p>本文链接:
                    <a href="{{ route('posts.show',array('id'=>$post->slug ? $post->slug : $post->id)) }}">{{ route('posts.show',array('id'=>$post->slug ? $post->slug : $post->id)) }}</a>
                </p>
                <p class="well">
                    <b class="text-danger">声明</b>
                    <br>
                    <br>
                    在转载或修改本文后发布的文章中注明原文来源信息的前提下，允许进行转载该篇文章或经修改后发布且不用告知本文作者。
                </p>
            </post>

            <div class="share">
                <div class="share-bar"></div>
            </div>

            @if($post->ifShowComments())
                @include('widgets.comments',
                [
                    'comment_key'      => $post->slug,
                    'comment_title'    => $post->title,
                    'comment_url'      => route('posts.show',$post->slug),
                    'commentable'      => $post,
                    'comments'         => isset($comments) ? $comments:[],
                    'redirect'         => request()->fullUrl(),
                    'commentable_type' => 'App\Post'
                ])
            @endif
        </div>
@endsection