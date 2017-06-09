@extends('app')

@section('head_title', $page->title)

@section('content')
    <section class="jumbotron geopattern" data-pattern-id="{{ $page->slug }}">
        <div class="container page-banner">
            <h1 class="jumbotron-title">{{ $page->title }}</h1>
            <p class="pull-right operation-bar">
                @can('update', $page)
                    <a class="operation ion-edit text-light"
                       href="{{ route('page.edit', ['id' => $page->id]) }}"></a>
                @endcan
                @can('delete', $page)
                    <a class="operation ion-trash-a text-light swal-dialog-target"
                       data-url="{{ route('page.destroy', ['id' => $page->id]) }}" data-dialog-msg="确定删除这个单页么?"
                       data-dialog-title=" " href="javascript:void(0)"></a>
                @endcan
            </p>
        </div>
    </section>
    <section class="container">
        <div class="row">
            <page class="page-content markdown-body">
                {!! $page->html_content !!}
                <br>
                <p>本文链接:
                    <a href="{{ route('page.show',array('id'=>$page->slug ? $page->slug : $page->id)) }}">{{ route('page.show',array('id'=>$page->slug ? $page->slug : $page->id)) }}</a>
                </p>
            </page>

            <div class="share">
                <div class="share-bar"></div>
            </div>

            @if($page->ifShowComments())
                @include('widgets.comments',
                [
                    'comment_key'      => $page->slug,
                    'comment_title'    => $page->title,
                    'comment_url'      => route('page.show',$page->slug),
                    'commentable'      => $page,
                    'comments'         => isset($comments) ? $comments:[],
                    'redirect'         => request()->fullUrl(),
                    'commentable_type' => 'App\Article'
                ])
            @endif
        </div>
@endsection