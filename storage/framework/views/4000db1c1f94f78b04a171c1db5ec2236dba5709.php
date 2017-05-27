<?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
            <a name="comment<?php echo e($loop->index + 1); ?>" href="<?php echo e($href); ?>">
                <img class="media-object img-thumbnail avatar avatar-middle"
                     src="<?php echo e($imgSrc); ?>">
            </a>
        </div>
        <div class="media-body comment-info">
            <div class="media-heading">
                <span class="name">
                    <a href="<?php echo e($href); ?>"><?php echo e($comment->username); ?></a>
                    <?php if(isAdminById($comment->user_id)): ?>
                        <label class="role-label">博主</label>
                    <?php endif; ?>
                </span>
                <span class="pull-right">
                    <a class="operation ion-reply reply-user-btn text-muted"
                       title="回复"
                       href="javascript:void (0);"
                       data-username="<?php echo e($comment->username); ?>"></a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $comment)): ?>
                        <a class="operation ion-trash-a swal-dialog-target text-muted"
                           title="删除"
                           href="javascript:void (0)"
                           data-dialog-msg="删除这条评论？"
                           data-url="<?php echo e(route('comment.destroy',$comment->id)); ?>"
                           data-enable-ajax='1'></a>
                    <?php endif; ?>
                </span>
                <div class="meta">
                    <a href="#comment<?php echo e($loop->index + 1); ?>">#<?php echo e($loop->index	+ 1); ?></a>
                    <span> ⋅  </span>
                    <span class="comment-time" data-toggle="tooltip" data-placement="right" title="<?php echo e($comment->created_at); ?>"><?php echo e($comment->created_at->diffForHumans()); ?></span>

                </div>
            </div>
            <div class="markdown-reply comment-content">
                <?php echo $comment->html_content; ?>

            </div>

        </div>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="meta-item center-block" style="padding:10px">暂无评论~~</p>
<?php endif; ?>
