<section id="hot-articles" class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">热文</div>
    </div>
    <ul class="list-group">
        <?php if(!empty($hotArticleList)): ?>
            <?php $__currentLoopData = $hotArticleList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotArticle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <a href="<?php echo e(route('article.show',array('id'=>$hotArticle->slug ? $hotArticle->slug : $hotArticle->id))); ?>" title="<?php echo e($hotArticle->title); ?>">
                        <span>
                            <?php echo e($hotArticle->title); ?>

                        </span>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
</section>