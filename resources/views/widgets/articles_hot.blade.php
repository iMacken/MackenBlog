<section id="hot-posts" class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">热文</div>
    </div>
    <ul class="list-group">
        @if(!empty($hotPostList))
            @foreach($hotPostList as $hotPost)
                <li class="list-group-item">
                    <a href="{{ route('post.show',array('id'=>$hotPost->slug ? $hotPost->slug : $hotPost->id)) }}" title="{{ $hotPost->title }}">
                        <span>
                            {{ $hotPost->title }}
                        </span>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</section>