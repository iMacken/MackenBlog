<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php echo $__env->yieldContent('header'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(elixir('css/app.css')); ?>">

    <?php echo $__env->yieldContent('styles'); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.BlogConfig = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]);?>;
    </script>
</head>

<body id="pjax-container" data-pjax>

<?php echo $__env->make('partials.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<footer id="site-footer">
    <div class="container">
        <div class="copyright pull-left mobile-block">
            © <?php echo e(date('Y')); ?>

            <span >macken.me</span>
        </div>
        <a href="https://github.com/RystLee/MackenBlog" target="_blank" aria-label="view source code">
            <span class="ion-social-github" title="GitHub"></span>
        </a>
        <a id="to-top" class="pull-right mobile-hidden" href="javascript:void(0)" ><span class="ion-arrow-up-a"></span></a>
    </div>
</footer>

<script src="<?php echo e(elixir('js/app.js')); ?>"></script>

<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
