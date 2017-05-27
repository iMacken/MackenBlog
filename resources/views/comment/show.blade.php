@forelse($comments as $comment)
    <li class="list-group-item media">
        <div class="media-left">
            <?php
            if ($comment->user_id) {
                $href = route('user.show', $comment->username);
            } else {
                $href = $comment->site ? httpUrl($comment->site) : 'javascript:void(0);';
            }
            $imgSrc = $comment->user ? $comment->user->avatar ?: config('app.default_avatar') : config('app.default_avatar');
            ?>
            <a name="comment{{ $loop->index + 1 }}" href="{{ $href }}">
                <img class="media-object img-thumbnail avatar avatar-middle"
                     src="{{ $imgSrc }}">
            </a>
        </div>
        <div class="media-body comment-info">
            <div class="media-heading">
                <span class="name">
                    <a href="{{ $href }}">{{ $comment->username }}</a>
                    @if(isAdminById($comment->user_id))
                        <label class="role-label">博主</label>
                    @endif
                </span>
                <span class="pull-right">
                    <a class="operation ion-reply reply-user-btn text-muted"
                       title="回复"
                       href="javascript:void (0);"
                       data-username="{{ $comment->username }}"></a>
                    @can('delete', $comment)
                        <a class="operation ion-trash-a swal-dialog-target text-muted"
                           title="删除"
                           href="javascript:void (0)"
                           data-dialog-msg="删除这条评论？"
                           data-url="{{ route('comment.destroy',$comment->id) }}"
                           data-enable-ajax='1'></a>
                    @endcan
                </span>
                <div class="meta">
                    <a href="#comment{{ $loop->index + 1 }}">#{{ $loop->index	+ 1 }}</a>
                    <span> ⋅  </span>
                    <span class="comment-time" data-toggle="tooltip" data-placement="right" title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span>

                </div>
            </div>
            <div class="markdown-reply comment-content">
                {!! $comment->html_content !!}
            </div>

        </div>
    </li>
@empty
    <p class="meta-item center-block" style="padding:10px">暂无评论~~</p>
@endforelse
