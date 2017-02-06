@section('styles')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
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
		@foreach($categories as $id => $name)
			@if((isset($article) ? $article->category_id : old('category_id', -1)) == $id)
				<option value="{{ $id }}" selected>{{ $name }}</option>
			@else
				<option value="{{ $id }}">{{ $name }}</option>
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
	<textarea type="text" name="content" id="editor" class="form-control" autofocus>{{ isset($article) ? $article->content : old('content') }}</textarea>
</div>

<div class="form-group">
	<label for="tag_list" class="control-label">标签</label>
    <select id="tag_list" name="tag_list[]" class="form-control" multiple>
        @foreach($tags as $id => $name)
            @if(isset($post) && $article->tags->contains($id))
                <option value="{{ $id }}" selected>{{ $name }}</option>
            @else
                <option value="{{ $id }}">{{ $name }}</option>
            @endif
        @endforeach
    </select>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success form-control">{{ $submitBtnTxt }}</button>
</div>

@section('scripts')
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
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



</script>
@endsection