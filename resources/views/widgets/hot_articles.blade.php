<section id="hot-articles" class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">热文</div>
    </div>
    <ul class="list-group">
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