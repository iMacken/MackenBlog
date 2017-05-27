<?php $__env->startSection('styles'); ?>
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/datetimepicker/bootstrap-datetimepicker.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php echo e(csrf_field()); ?>


<div class="form-group">
	<label for="title" class="control-label">标题</label>
	<input type="text" name="title" id="title" class="form-control" value="<?php echo e(isset($article) ? $article->title : old('title')); ?>" autofocus>
</div>

<div class="form-group">
	<label for="slug" class="control-label">别名</label>
	<input type="text" name="slug" id="slug" class="form-control" value="<?php echo e(isset($article) ? $article->slug : old('slug')); ?>" autofocus>
</div>

<div class="form-group">
	<label for="category_id" class="control-label">分类</label>
	<select name="category_id" class="form-control">
		<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if((isset($article) ? $article->category_id : old('category_id', -1)) == $category->id): ?>
				<option value="<?php echo e($category->id); ?>" selected><?php echo e($category->name); ?></option>
			<?php else: ?>
				<option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
			<?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</select>
</div>

<div class="form-group">
	<label for="image" class="control-label">配图</label>
	<input type="text" name="image" id="image" class="form-control" value="<?php echo e(isset($article) ? $article->image : old('image')); ?>" autofocus>
</div>

<div class="form-group">
	<label for="editor" class="control-label">正文</label>
	<textarea type="text" name="content" id="editor" class="form-control" autofocus><?php echo isset($article) ? $article->content : old('content'); ?></textarea>
</div>

<div class="form-group">
	<label for="tag_list" class="control-label">标签</label>
    <select id="tag_list" name="tag_list[]" class="form-control" multiple>
        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($article) && $article->tags->contains($tag->id)): ?>
                <option value="<?php echo e($tag->id); ?>" selected><?php echo e($tag->name); ?></option>
            <?php else: ?>
                <option value="<?php echo e($tag->id); ?>"><?php echo e($tag->name); ?></option>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group date">
    <div class="row">
        <div class="col-sm-12">
	        <label for="image" class="control-label">发布时间</label>
            <input type="text" name="published_at" class="form-control" id='datetimepicker' value="<?php echo e(isset($article) ? $article->published_at : old('published_at')); ?>" autofocus>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success form-control"><?php echo e($submitBtnTxt); ?></button>
</div>

<?php $__env->startSection('scripts'); ?>
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="<?php echo e(asset('vendor/datetimepicker/bootstrap-datetimepicker.min.js')); ?>"></script>
<script>
	$('#tag_list').select2({
		placeholder: '选择一个标签',
		tags: true
	});

    new SimpleMDE({
        element: document.getElementById("editor"),
        placeholder: 'Please input the article content.',
        autoDownloadFontAwesome: true
    })

    $(function () {
        $('#datetimepicker').datetimepicker({
            locale: 'zh-CN',
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: "ion-clock",
                date: "ion-calendar",
                up: "ion-arrow-up-a",
                down: "ion-arrow-down-a",
                previous: "ion-chevron-left",
                next: "ion-chevron-right"
            }
        });
    });

</script>
<?php $__env->stopSection(); ?>