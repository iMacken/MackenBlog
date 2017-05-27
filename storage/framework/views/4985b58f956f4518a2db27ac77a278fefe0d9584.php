<nav id="site-header" class="navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <a class="navbar-brand" href="/">Macken Stack</a>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li><a href="/" title="Home">主页</a></li>
                <?php if(!empty($navList)): ?>
                    <?php $__currentLoopData = $navList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e($nav->url); ?>" title="<?php echo e($nav->name); ?>"><?php echo e($nav->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
            <?php if(Auth::check()): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"><?php echo e(Auth::user()->name); ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo e(route('article.create')); ?>">写文章</a></li>
                            <li><a href="javascript:void(0)"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">登出</a>
                            </li>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                  style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </ul>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo e(route('login')); ?>">登录</a></li>
                </ul>
            <?php endif; ?>
            <form data-pjax class="navbar-form nav navbar-nav navbar-right" role="search"
                  action="<?php echo e(route('search')); ?>">
                <div class="form-group">
                    <input type="text" id="search-keyword" name="keyword" value="<?php echo e(isset($keyword) ? $keyword : ''); ?>"
                           class="form-control" placeholder="搜索">
                </div>
            </form>
        </div>
    </div>
</nav>