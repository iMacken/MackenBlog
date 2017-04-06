<section id="tags" class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">标签</div>
    </div>
    <div>
        @if(!empty($tagList))
            @foreach($tagList as $tag)
                <a href="{{ url('tag',['id'=>$tag->name]) }}" title="{{ $tag->name }}">{{ $tag->name }}</a>
            @endforeach
        @endif
    </div>
</section>