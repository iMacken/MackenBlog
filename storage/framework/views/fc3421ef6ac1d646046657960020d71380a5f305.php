<?php if(!empty($linkList)): ?>
    <section id="links" class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">友链</div>
        </div>
        <ul class="panel-body">
            <?php $__currentLoopData = $linkList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e($link->url); ?>" target="_blank" >
                        <?php echo e($link->name); ?>

                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </section>
<?php endif; ?>