
<link rel="stylesheet" href="{{ asset('plugins/editor.md/css/editormd.min.css')}}" />
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}" />

<div class="form-group">
	{!!  Form::label('title', '标题') !!}
	{!!  Form::text('title', null, ['class' => 'form-control']) !!}
	<font color="red">{{ $errors->first('title') }}</font>
</div>

<div class="form-group">
	{!!  Form::label('slug', '别名') !!}
	{!!  Form::text('slug', null, ['class' => 'form-control']) !!}
	@if($errors->has('slug'))
	<font color="red">{{ $errors->first('slug') }}</font>
	@endif
	<font>只允许包含小写英文字母、数字以及"-"</font>	
</div>

<div class="form-group">
	{!! Form::label('category_id', '所属分类') !!}
	{!! Form::select('category_id', $categoryTree , null , ['class' => 'form-control']) !!}
	<font color="red">{{ $errors->first('category_id') }}</font>
</div>

<div class="form-group">
	{!! Form::label('pic', '配图') !!}
	{!! Form::file('pic', null, ['class' => 'form-control']) !!}
	<font color="red">{{ $errors->first('pic') }}</font>
</div>

<div class="form-group">
	{!!  Form::label('content', '内容') !!}
	<div id="editormd">
	{!!  Form::textarea('content', null, ['class' => 'form-control']) !!}
	</div>
	<font color="red">{{ $errors->first('content') }}</font>
</div>

<div class="form-group">
	{!!  Form::label('tag_list', '标签') !!}
	{!!  Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
	<font color="red">{{ $errors->first('tag_list') }}</font>
</div>

<div class="form-group">
	{!!  Form::submit($submitBtnTxt, ['class' => 'btn btn-success form-control']) !!}
</div>

<script type="text/javascript" src="{{ asset('plugins/editor.md/editormd.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script>
	$('#tag_list').select2({
		placeholder: '选择一个标签',
		tags: true,
		ajax: {
			dataType: 'json',
			url: '{{ url("backend/api/tags") }}',
			delay: 200,
			data: function (params, page) {
				return {
					search :params.term
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

	$(function() {
        var editor = editormd("editormd", {
            emoji: true,
            flowChart : true,
            tex  : true,
            htmlDecode : true,
            htmlDecode : "style,script,iframe,sub,sup",
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadToken : '{{ csrf_token() }}',
            imageUploadURL : "{{ url(config('editor.uploadUrl')) }}",
            height  : 420,
            path : "{{ asset('plugins/editor.md/lib') }}/" // Autoload modules mode, codemirror, marked... dependents libs path
        });
    });
</script>