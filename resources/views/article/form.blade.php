@section('styles')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
@endsection

<div class="form-group">
	{!!  Form::label('title', '标题') !!}
	{!!  Form::text('title', null, ['class' => 'form-control']) !!}
	@if ($errors->has('title'))
		<span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
	@endif
</div>

<div class="form-group">
	{!!  Form::label('slug', '别名') !!}
	{!!  Form::text('slug', null, ['class' => 'form-control']) !!}
	@if($errors->has('slug'))
		<span class="help-block">
            <strong>{{ $errors->first('slug') }}</strong>
			<p>只允许包含小写英文字母、数字以及"-"</p>
        </span>
	@endif

</div>

<div class="form-group">
	{!! Form::label('category_id', '所属分类') !!}
	{!! Form::select('category_id', $categories , null , ['class' => 'form-control']) !!}
	@if ($errors->has('category_id'))
		<span class="help-block">
            <strong>{{ $errors->first('category_id') }}</strong>
        </span>
	@endif
</div>

<div class="form-group">
	{!! Form::label('image', '配图') !!}
    {!!  Form::text('image', null, ['class' => 'form-control']) !!}
	@if ($errors->has('image'))
		<span class="help-block">
            <strong>{{ $errors->first('image') }}</strong>
        </span>
	@endif
</div>

<div class="form-group">
	{!!  Form::label('content', '内容') !!}
	{!!  Form::textarea('content', null, ['class' => 'form-control', 'id' => 'editor']) !!}
	@if ($errors->has('content'))
		<span class="help-block">
            <strong>{{ $errors->first('content') }}</strong>
        </span>
	@endif
</div>

<div class="form-group">
	{!!  Form::label('tag_list', '标签') !!}
	{!!  Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
	@if ($errors->has('tag_list'))
		<span class="help-block">
            <strong>{{ $errors->first('tag_list') }}</strong>
        </span>
	@endif
</div>

<div class="form-group">
	{!!  Form::submit($submitBtnTxt, ['class' => 'btn btn-success form-control']) !!}
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