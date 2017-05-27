<div class="panel panel-default" id="comment-list">
    <div class="panel-heading clearfix">
        <div class="total pull-left">评论数 <span class="badge"><?php echo e($article->comments_count); ?></span> </div>
        
            
            
        
    </div>
    <div class="panel-body">
        <ul id="comments-container" class="list-group" data-api-url="<?php echo e(route('comment.show',[$commentable->id,
             'commentable_type'=>$commentable_type,
             'redirect'=>(isset($redirect) && $redirect ? $redirect:'')])); ?>">
            <?php if(isset($comments) && !empty($comments)): ?>
                <?php echo $__env->make('comment.show',$comments, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
        </ul>
        <form id="comment-form" method="POST" action="<?php echo e(route('comment.store')); ?>">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="commentable_id" value="<?php echo e($commentable->id); ?>">
            <input type="hidden" name="commentable_type" value="<?php echo e($commentable_type); ?>">
            <?php $if_allow_comment = $commentable->ifAllowComment()?>
            <div class="form-group">
                <label for="comment-content"><strong>评论</strong></label>
                <textarea placeholder="支持 Markdown" style="resize: vertical" id="comment-content" name="content" rows="5" spellcheck="false" class="form-control markdown-content autosize-target" required></textarea>
            </div>
            <?php if(!auth()->check()): ?>
                <div class="form-group">
                    <label for="username">姓名</label>
                    <input <?php echo e($if_allow_comment?' ':' disabled '); ?> class="form-control" id="username" type="text" name="username" placeholder="您的大名" required>
                </div>
                <div class="form-group">
                    <label for="email">邮箱</label>
                    <input <?php echo e($if_allow_comment?' ':' disabled '); ?> class="form-control" id="email" type="email" name="email" placeholder="邮箱不会公开" required>
                </div>
                <div class="form-group">
                    <label for="website">个人网站</label>
                    <input <?php echo e($if_allow_comment?' ':' disabled '); ?> class="form-control" id="website" type="text" name="website" placeholder="可不填">
                </div>
            <?php endif; ?>
            <div class="form-group">
                <button <?php echo e($if_allow_comment?' ':' disabled '); ?> type="submit" id="comment-submit" class="btn btn-primary">发表</button>
            </div>
            <div class="box preview markdown-comment" id="preview-box" style="display:none;"></div>
        </form>
    </div>
</div>