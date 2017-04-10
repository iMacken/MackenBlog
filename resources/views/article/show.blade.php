@extends('article.base')

@section('header')
    <title>{{ $article->title }} - {{ setting_config('title','') }}</title>
    <meta name="keywords" content="{{ $article->title }},{{ setting_config('seo_key') }}" />
    <meta name="description" content="{!! str_limit(preg_replace('/\s/', '',strip_tags(convert_markdown($article->content))),100) !!},{{ setting_config('seo_desc') }}">
@endsection

@section('jumbotron-title')
    {{ $article->title }}
@endsection

@unless(isset($isSinglePage))

@section('jumbotron-desc')
    {!! $article->description !!}
@endsection

@section('jumbotron-meta')
    <span class="ion-calendar"></span> {{ $article->published_at->diffForHumans() }}
    &nbsp;&nbsp;<span class="ion-ios-folder"></span>
    <a href="/category/{{ $article->category->slug }}">{{ $article->category->name }}</a>
    &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
    @if ($article->tags)
        @foreach($article->tags as $tag)
            <a href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>&nbsp;
        @endforeach
    @endif
@endsection

@endunless

@section('left')
    <article class="article-content markdown-body">
        {!! $article->html_content !!}
        <br>
        <p>本文链接: <a href="{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}">{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}</a></p>
        <p class="well">
            <b class="text-danger">声明</b>
            <br>
            <br>
            在转载或修改本文后发布的文章中注明原文来源信息的前提下，允许进行转载该篇文章或经修改后发布且不用告知本文作者。
        </p>
    </article>
    <p>
       <span class="pull-right"><a class="operation op-edit ion-edit" href="{{ route('article.edit', ['id' => $article->id]) }}"></a><a class="operation op-delete ion-trash-a" data-target="{{ route('article.destroy', ['id' => $article->id]) }}" href="javascript:void(0)"></a></span>
    </p>
    <div class="share">
        <div class="share-bar"></div>
    </div>
    
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

@endsection

@section('scripts')
    @include('partials.delete')
@endsection