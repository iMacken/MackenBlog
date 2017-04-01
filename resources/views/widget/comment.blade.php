{!! $comment_type = $commentable->getCommentType() !!}

@if($comment_type == 'raw')
    @include('widget.raw_comment')
@elseif($comment_type == 'duoshuo')
    @include('widget.duoshuo_comment')
@elseif($comment_type == 'disqus')
    @include('widget.disqus_comment')
@endif