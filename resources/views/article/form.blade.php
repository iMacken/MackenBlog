
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
	{!! Form::file('image', null, ['class' => 'form-control']) !!}
	@if ($errors->has('image'))
		<span class="help-block">
            <strong>{{ $errors->first('image') }}</strong>
        </span>
	@endif
</div>

<div class="form-group">
	{!!  Form::label('content', '内容') !!}
	<div id="editormd">
	{!!  Form::textarea('content', null, ['class' => 'form-control']) !!}
	</div>
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
<script>
	$('#tag_list').select2({
		placeholder: '选择一个标签',
		tags: true,
		ajax: {
            type: 'post',
			dataType: 'json',
			url: '{{ route("api.tag.search") }}',
			delay: 200,
			data: function (params, page) {
				return {
					keyword :params.term
				}
			},
			processResults: function(res, page) {
                return {
                    results: $.map(res.data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
		},
		cache: true,
		minimumInputLength: 1,  //至少输入多少个字符后才会去调用ajax  
        maximumInputLength: 20, //最多能输入多少个字符后才会去调用ajax  
        minimumResultsForSearch: 1,   
	});	

	{{--$(function() {--}}
        {{--var editor = editormd("editormd", {--}}
            {{--emoji: true,--}}
            {{--flowChart : true,--}}
            {{--tex  : true,--}}
            {{--htmlDecode : true,--}}
            {{--htmlDecode : "style,script,iframe,sub,sup",--}}
            {{--imageUpload : true,--}}
            {{--imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],--}}
            {{--imageUploadToken : '{{ csrf_token() }}',--}}
            {{--imageUploadURL : "{{ url(config('editor.uploadUrl')) }}",--}}
            {{--height  : 420,--}}
            {{--path : "{{ asset('plugins/editor.md/lib') }}/" // Autoload modules mode, codemirror, marked... dependents libs path--}}
        {{--});--}}
    {{--});--}}
</script>
@endsection