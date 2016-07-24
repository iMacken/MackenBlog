
<section class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">热文</div>
    </div>
    <ul class="list-group" id="hot-article-list">
        @if(!empty($hotArticleList))
            @foreach($hotArticleList as $hotArticle)
                <li class="list-group-item">
                    <a href="{{ route('article.show',array('id'=>$hotArticle->slug ? $hotArticle->slug : $hotArticle->id)) }}" title="{{ $hotArticle->title }}">
                        <span>
                            {{ $hotArticle->title }}
                        </span>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</section>

<section class="panel panel-primary">
    <div class="panel-heading">
    <div class="panel-title">标签</div>
    </div>
    <div id="tag-cloud">
        @if(!empty($tagList))
            @foreach($tagList as $tag)
                <a href="{{ url('tag',['id'=>$tag->name]) }}" title="{{ $tag->name }}">{{ $tag->name }}</a>
            @endforeach
        @endif
    </div>
</section>

<section class="panel panel-primary">
    <div class="panel-heading">
    <div class="panel-title">归档</div>
    </div>
    <ul class="list-group" id="archive-list">
        @if(!empty($archiveList))
            @foreach($archiveList as $v)
                <a href="{{ route('article-archive-list', sscanf($v->archive, "%d %d")) }}">
                <li class="list-group-item">
                    <span class="badge">{{ $v->count }}</span>
                        <span>
                            {{ vsprintf("%s年  %s月", sscanf($v->archive, "%s %s")) }}
                        </span>
                    
                </li>
                </a>
            @endforeach
        @endif
    </ul>
</section>

@if(!empty($linkList))
<section class="panel panel-primary">
    <div class="panel-heading">
    <div class="panel-title">友链</div>
    </div>
    <ul id="friend-links">
        @foreach($linkList as $link)
            <li>
                <a href="{{ $link->url }}" target="_blank" >
                        {{ $link->name }}
                </a>
            </li>
        @endforeach
    </ul>
</section>
@endif