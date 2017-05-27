<?php $__env->startSection('header'); ?>
    <title><?php echo e($article->title); ?></title>
    <meta name="keywords" content="<?php echo e($article->title); ?>"/>
    <meta name="description" content="<?php echo e($article->description); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="jumbotron geopattern" data-pattern-id="<?php echo e($article->slug); ?>">
        <div class="container article-banner">
            <h1 class="jumbotron-title"><?php echo e($article->title); ?></h1>
            <p class="jumbotron-desc"><?php echo e($article->descrition); ?></p>
            <p class="jumbotron-meta">
                <span class="ion-calendar"></span> <?php echo e($article->published_at->diffForHumans()); ?>

                &nbsp;&nbsp;<span class="ion-ios-folder"></span>
                <a href="/category/<?php echo e($article->category->slug); ?>"><?php echo e($article->category->name); ?></a>
                &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
                <?php if($article->tags): ?>
                    <?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="/tag/<?php echo e($tag->name); ?>"><?php echo e($tag->name); ?></a>&nbsp;
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </p>
            <p class="pull-right operation-bar">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $article)): ?>
                    <a class="operation ion-edit text-light"
                       href="<?php echo e(route('article.edit', ['id' => $article->id])); ?>"></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $article)): ?>
                    <a class="operation ion-trash-a text-light swal-dialog-target"
                       data-url="<?php echo e(route('article.destroy', ['id' => $article->id])); ?>" data-dialog-msg="确定删除这篇文章么?"
                       data-dialog-title=" " href="javascript:void(0)"></a>
                <?php endif; ?>
            </p>
        </div>
    </section>
    <section class="container">
        <div class="row">
            <article class="article-content markdown-body">
                <?php echo $article->html_content; ?>

                <br>
                <p>本文链接:
                    <a href="<?php echo e(route('article.show',array('id'=>$article->slug ? $article->slug : $article->id))); ?>"><?php echo e(route('article.show',array('id'=>$article->slug ? $article->slug : $article->id))); ?></a>
                </p>
                <p class="well">
                    <b class="text-danger">声明</b>
                    <br>
                    <br>
                    在转载或修改本文后发布的文章中注明原文来源信息的前提下，允许进行转载该篇文章或经修改后发布且不用告知本文作者。
                </p>
            </article>

            <div class="share">
                <div class="share-bar"></div>
            </div>

            <?php echo $__env->make('widgets.comments',
            [
                'comment_key'      => $article->slug,
                'comment_title'    => $article->title,
                'comment_url'      => route('article.show',$article->slug),
                'commentable'      => $article,
                'comments'         => isset($comments) ? $comments:[],
                'redirect'         => request()->fullUrl(),
                'commentable_type' => 'App\Article'
            ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>