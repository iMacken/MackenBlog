@forelse($comments as $comment)
    <li class="list-group-item media">
        <div class="avatar avatar-container pull-left">
            <?php
            if ($comment->user_id) {
                $href = route('user.show', $comment->username);
            } else {
                $href = $comment->site ? httpUrl($comment->site) : 'javascript:void(0);';
            }
            $imgSrc = $comment->user ? $comment->user->avatar : config('app.avatar');
            $imgSrc = processImageViewUrl($imgSrc, 40, 40);
            ?>
            <a name="comment{{ $loop->index + 1 }}" href="{{ $href }}">
                <img width="40px" height="40px" class="media-object img-thumbnail avatar avatar-middle"
                     src="{{ $imgSrc }}">
            </a>
        </div>
        <div class="comment-info">
            <div class="media-heading">
                <span class="name">
                    <a href="{{ $href }}">{{ $comment->username }}</a>
                    @if(isAdminById($comment->user_id))
                        <label class="role-label">博主</label>
                    @endif
                </span>
                <span class="comment-operation pull-right">
                    <a href="#comment{{ $loop->index + 1 }}"
                       style="color: #ccc;font-size: 12px">#{{ $loop->index	+ 1 }}</a>
                </span>
                <div class="meta">
                    <abbr class="timeago" title="{{ $comment->created_at }}">{{ $comment->created_at }}</abbr>
                </div>
            </div>
            <div class="media-body markdown-reply comment-content">
                {!! $comment->html_content !!}

                <div class="pull-right">
                    <a class="ion-reply reply-user-btn"
                       title="回复"
                       href="javascript:void (0);"
                       data-username="{{ $comment->username }}"></a>
                    <a class="ion-edit"
                       title="编辑"
                       href="{{ route('comment.edit',[$comment->id,'redirect'=>(isset($redirect) && $redirect.'#'.$loop->index ? $redirect : '')]) }}"></a>
                    <a class="ion-android-delete swal-dialog-target"
                       title="删除"
                       href="javascript:void (0)"
                       data-dialog-msg="删除这条评论？"
                       data-url="{{ route('comment.destroy',$comment->id) }}"></a>
                </div>
            </div>

        </div>
    </li>
@empty
    <p class="meta-item center-block" style="padding:10px">暂无评论~~</p>
@endforelse
