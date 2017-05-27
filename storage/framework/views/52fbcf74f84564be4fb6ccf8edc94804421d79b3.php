<?php $__env->startSection('header'); ?>
    <title><?php echo e($jumbotron['title']); ?></title>
    <meta name="keywords" content=""/>
    <meta name="description" content="">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="jumbotron home-jumbotron">
        <div class="container article-banner">
            <h1 class="jumbotron-title"><?php echo e($jumbotron['title']); ?></h1>
            <p class="jumbotron-desc"><?php echo e($jumbotron['description']); ?></p>
        </div>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-sm-8">
                <ol class="article-list">
                    <?php if(!empty($articles)): ?>
                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="article-list-item">
                                <h3 class="article-list-name">
                                    <a href="<?php echo e(route('article.show',array('id'=>$article->slug ? $article->slug : $article->id))); ?>"
                                       title="<?php echo e($article->title); ?>">
                                        <?php echo e($article->title); ?>

                                    </a>
                                </h3>
                                <p class="article-list-description">
                                    <?php echo e(str_cut(convert_markdown($article->content),80)); ?>

                                </p>
                                <p class="article-list-meta">
                                    <span class="ion-calendar"></span><?php echo e($article->published_at->diffForHumans()); ?>

                                    &nbsp;&nbsp;<span class="ion-ios-folder"></span><a
                                            href="/category/<?php echo e($article->category->slug); ?>"><?php echo e($article->category->name); ?></a>
                                    &nbsp;&nbsp;<span class="ion-ios-pricetag"></span>
                                    <?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="/tag/<?php echo e($tag->slug); ?>"><?php echo e($tag->name); ?></a>&nbsp;
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ol>
                <div class="pagination text-align">
                    <nav>
                        <?php echo $articles->links(); ?>

                    </nav>
                </div>
            </div>
            <div class="col-sm-4">
                <?php echo $__env->make('partials.right', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>