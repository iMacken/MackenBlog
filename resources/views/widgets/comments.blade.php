<div class="panel panel-default" id="comment-list">
    <div class="panel-heading clearfix">
        <div class="total pull-left">评论数 <span class="badge" id="comment-count">{{ $article->comments_count }}</span> </div>
        {{--<div class="btn-group pull-right" role="group" aria-label="comments order">--}}
            {{--<a class="btn btn-default btn-sm active popover-with-html" data-content="按照时间排序" href="" type="button" data-original-title="" title="">时间</a>--}}
            {{--<a class="btn btn-default btn-sm  popover-with-html" data-content="按照投票排序" href="" type="button" data-original-title="" title="">投票</a>--}}
        {{--</div>--}}
    </div>
    <div class="panel-body">
        <ul id="comments-container" class="list-group" data-api-url="{{ route('comment.show',[$commentable->id,
             'commentable_type'=>$commentable_type,
             'redirect'=>(isset($redirect) && $redirect ? $redirect:'')]) }}">
            @if(isset($comments) && !empty($comments))
                @include('comment.show',$comments)
            @endif
        </ul>
        <form id="comment-form" method="POST" action="{{ route('comment.store') }}">
            {{ csrf_field() }}
            <input type="hidden" name="commentable_id" value="{{ $commentable->id }}">
            <input type="hidden" name="commentable_type" value="{{ $commentable_type }}">
            <?php $if_allow_comment = $commentable->ifAllowComment()?>
            <div class="form-group">
                <label for="comment-content"><strong>评论</strong></label>
                <textarea placeholder="支持 Markdown" style="resize: vertical" id="comment-content" name="content" rows="5" spellcheck="false" class="form-control markdown-content autosize-target" required></textarea>
            </div>
            @if(!auth()->check())
                <div class="form-group">
                    <label for="username">姓名</label>
                    <input {{ $if_allow_comment?' ':' disabled ' }} class="form-control" id="username" type="text" name="username" placeholder="您的大名" required>
                </div>
                <div class="form-group">
                    <label for="email">邮箱</label>
                    <input {{ $if_allow_comment?' ':' disabled ' }} class="form-control" id="email" type="email" name="email" placeholder="邮箱不会公开" required>
                </div>
                <div class="form-group">
                    <label for="website">个人网站</label>
                    <input {{ $if_allow_comment?' ':' disabled ' }} class="form-control" id="website" type="text" name="website" placeholder="可不填">
                </div>
            @endif
            <div class="form-group">
                <button {{ $if_allow_comment?' ':' disabled ' }} type="submit" id="comment-submit" class="btn btn-primary">发表</button>
            </div>
            <div class="box preview markdown-comment" id="preview-box" style="display:none;"></div>
        </form>
    </div>
</div>