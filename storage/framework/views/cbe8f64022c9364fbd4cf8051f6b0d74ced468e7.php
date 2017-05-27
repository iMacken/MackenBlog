<?php $__env->startSection('content'); ?>
    <section class="container">
        <div class="row">
            <br>
            <?php echo $__env->make('partials.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="panel panel-default">
                <div class="panel-heading">修改文章</div>
                <div class="panel-body">
                    <form role="form" action="<?php echo e(route('article.update',$article->id)); ?>" method="POST">
                        <?php echo e(method_field('patch')); ?>

                        <?php echo $__env->make('article.form', ['submitBtnTxt'=>'更新'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>