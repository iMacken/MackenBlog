<section id="tags" class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">标签</div>
    </div>
    <div>
        <?php if(!empty($tagList)): ?>
            <?php $__currentLoopData = $tagList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(url('tag',['id'=>$tag->name])); ?>" title="<?php echo e($tag->name); ?>"><?php echo e($tag->name); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</section>