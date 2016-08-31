@extends('pages.base')

@section('header')
    <title>{{ $article->title }} - {{ setting_config('title','') }}</title>
    <meta name="keywords" content="{{ $article->title }},{{ setting_config('seo_key') }}" />
    <meta name="description" content="{!! str_limit(preg_replace('/\s/', '',strip_tags(convert_markdown($article->content))),100) !!},{{ setting_config('seo_desc') }}">
@endsection

@section('styles')
    <style type="text/css">
        .ds-sync,.ds-powered-by {
            display: none !important;
        }
    </style>
@endsection

@section('jumbotron-title')
    {{ $article->title }}
@endsection

@unless(isset($isSinglePage))

@section('jumbotron-desc')
    {{ str_cut(convert_markdown($article->content),40) }}
@endsection

@section('jumbotron-meta')
    <span class="fa fa-calendar"></span> {{ $article->created_at->format('Y-m-d') }}
    &nbsp;&nbsp;<span class="fa fa-folder-o"></span>
    <a href="/category/{{ $article->category->slug }}">{{ $article->category->name }}</a>
    &nbsp;&nbsp;<span class="fa fa-tags"></span>
    @if ($article->tags)
        @foreach($article->tags as $tag)
            <a href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>&nbsp;
        @endforeach
    @endif
@endsection

@endunless

@section('left')
    <article class="article-content markdown-body">
        {!! convert_markdown($article->content) !!}
        <br>
        <p>本文链接: <a href="{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}">{{ route('article.show',array('id'=>$article->slug ? $article->slug : $article->id)) }}</a></p>
        <p class="well">
            <b>声明</b>
            <br>
            <br>
            在转载或修改本文后发布的文章中注明原文来源信息的前提下，允许进行转载该篇文章或经修改后发布且不用告知本文作者。
        </p>
    </article>
    <div class="share">
        <div class="share-bar"></div>
    </div>
    <div id="disqus_thread">
        评论加载中...
        <br>
        <br>
        注：如果长时间无法加载，请针对 disq.us | disquscdn.com | disqus.com 启用代理。
    </div>
<script>

/**
 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables */

var disqus_config = function () {
    this.page.url = "{{ route('article.show',array('id'=>$article->id)) }}";  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = "{{ 'article_'.$article->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};

(function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = '//macken-stack.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                    
@endsection