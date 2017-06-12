@section('styles')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endsection

{{ csrf_field() }}

<div class="form-group">
	<label for="title" class="control-label">标题</label>
	<input type="text" name="title" id="title" class="form-control" value="{{ isset($article) ? $article->title : old('title') }}" autofocus>
</div>

<div class="form-group">
	<label for="slug" class="control-label">别名</label>
	<input type="text" name="slug" id="slug" class="form-control" value="{{ isset($article) ? $article->slug : old('slug') }}" autofocus>
</div>

<div class="form-group">
	<label for="category_id" class="control-label">分类</label>
	<select name="category_id" class="form-control">
		@foreach($categories as $category)
			@if((isset($article) ? $article->category_id : old('category_id', -1)) == $category->id)
				<option value="{{ $category->id }}" selected>{{ $category->name }}</option>
			@else
				<option value="{{ $category->id }}">{{ $category->name }}</option>
			@endif
		@endforeach
	</select>
</div>

<div class="form-group">
	<label for="image" class="control-label">配图</label>
	<input type="text" name="image" id="image" class="form-control" value="{{ isset($article) ? $article->image : old('image') }}" autofocus>
</div>

<div class="form-group">
	<label for="editor" class="control-label">正文</label>
	<textarea type="text" name="content" id="editor" class="form-control" autofocus>{!! isset($article) ? $article->content : old('content') !!}</textarea>
</div>

<div class="form-group">
    <label for="excerpt" class="control-label">摘要</label>
    <textarea type="text" name="excerpt" id="excerpt" class="form-control" autofocus>{!! isset($article) ? $article->excerpt : old('excerpt') !!}</textarea>
</div>

<div class="form-group">
	<label for="tag_list" class="control-label">标签</label>
    <select id="tag_list" name="tag_list[]" class="form-control" multiple>
        @foreach($tags as $tag)
            @if(isset($article) && $article->tags->contains($tag->id))
                <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
            @else
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endif
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="if_show_comments" class="control-label">评论显示</label>
    <select style="margin-top: 5px" id="if_show_comments" name="if_show_comments" class="form-control">
        @php $if_show_comments = isset($article) ? $article->getConfig('if_show_comments', 'true') : 'true'; @endphp
        <option value="true" {{ $if_show_comments == 'true'?' selected' : '' }}>开启</option>
        <option value="false" {{ $if_show_comments == 'false'?' selected' : '' }}>隐藏</option>
    </select>
</div>

<div class="form-group">
    <label for="if_allow_comment" class="control-label">评论开关</label>
    <select id="if_allow_comment" name="if_allow_comment" class="form-control">
        @php $if_allow_comment = isset($article) ? $article->getConfig('if_allow_comment', 'true') : 'true'; @endphp
            <option value="true" {{ $if_allow_comment == 'true'?' selected' : '' }}>允许</option>
        <option value="false" {{ $if_allow_comment == 'false'?' selected' : '' }}>禁止</option>
    </select>
</div>

<div class="form-group">
    <label>
        @php $is_draft = isset($article) ? $article->getConfig('is_draft', 'false') : 'false'; @endphp
        <input type="hidden" name="is_draft" value="false">
        <input type="checkbox" name="is_draft" id="is_draft" value="true" {{ $is_draft === 'true'? 'checked' : '' }}>草稿
    </label>
    <label>
        @php $is_original = isset($article) ? $article->getConfig('is_original', 'false') : 'false'; @endphp
        <input type="hidden" name="is_original" value="false">
        <input type="checkbox" name="is_original" id="is_original" value="true" {{ $is_original === 'true'? 'checked' : '' }}>原创
    </label>
</div>

<div class="form-group date" style="display:none">
    <div class="row">
        <div class="col-sm-12">
	        <label for="image" class="control-label">发布时间</label>
            <input type="text" name="published_at" class="form-control" id='published_at' value="{{ isset($article) ? $article->published_at : old('published_at') }}" autofocus>
        </div>
    </div>
</div>



<div class="form-group">
    <button type="submit" class="btn btn-success form-control">{{ $submitBtnTxt }}</button>
</div>

@section('scripts')
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script>
	$('#tag_list').select2({
		placeholder: '选择一个标签',
		tags: true
	});

    new SimpleMDE({
        element: document.getElementById("editor"),
        placeholder: 'Please input the article content.',
        autoDownloadFontAwesome: true
    });


    $(function () {
        $('#published_at').datetimepicker({
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

        function setPublishedAtStatus()
        {
            var $publishedAt = $('#published_at').closest('.form-group');
            if ($('#is_draft').prop('checked')) {
                $publishedAt.hide().find('#published_at').attr('disabled', 'disabled');
            } else {
                $publishedAt.show().find('#published_at').removeAttr('disabled');
            }
        }
        setPublishedAtStatus();
        $('#is_draft').click(function() {
            setPublishedAtStatus();
        });
    });


</script>
@endsection