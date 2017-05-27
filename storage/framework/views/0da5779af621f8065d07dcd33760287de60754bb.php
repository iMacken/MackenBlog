<section id="archives" class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">归档</div>
    </div>
    <ul class="list-group" >
        <?php if(!empty($archiveList)): ?>
            <?php $__currentLoopData = $archiveList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('article-archive-list', sscanf($v->archive, "%d %d"))); ?>">
                    <li class="list-group-item">
                        <span class="badge"><?php echo e($v->count); ?></span>
                        <span>
                            <?php echo e(vsprintf("%s年  %s月", sscanf($v->archive, "%s %s"))); ?>

                        </span>
                    </li>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
</section>