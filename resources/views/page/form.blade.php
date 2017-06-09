@section('styles')
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/datetimepicker/bootstrap-datetimepicker.min.css') }}">
@endsection

{{ csrf_field() }}

<div class="form-group">
	<label for="title" class="control-label">标题</label>
	<input type="text" name="title" id="title" class="form-control" value="{{ isset($page) ? $page->title : old('title') }}" autofocus>
</div>

<div class="form-group">
	<label for="slug" class="control-label">别名</label>
	<input type="text" name="slug" id="slug" class="form-control" value="{{ isset($page) ? $page->slug : old('slug') }}" autofocus>
</div>

<div class="form-group">
	<label for="editor" class="control-label">正文</label>
	<textarea type="text" name="content" id="editor" class="form-control" autofocus>{!! isset($page) ? $page->content : old('content') !!}</textarea>
</div>

<div class="form-group">
    <label for="if_show_comments" class="control-label">评论显示</label>
    <select style="margin-top: 5px" id="if_show_comments" name="if_show_comments" class="form-control">
        @php $if_show_comments = isset($page) ? $page->getConfig('if_show_comments', 'true') : 'true'; @endphp
        <option value="true" {{ $if_show_comments == 'true'?' selected' : '' }}>开启</option>
        <option value="false" {{ $if_show_comments == 'false'?' selected' : '' }}>隐藏</option>
    </select>
</div>

<div class="form-group">
    <label for="if_allow_comment" class="control-label">评论开关</label>
    <select id="if_allow_comment" name="if_allow_comment" class="form-control">
        @php $if_allow_comment = isset($page) ? $page->getConfig('if_allow_comment', 'true') : 'true'; @endphp
            <option value="true" {{ $if_allow_comment == 'true'?' selected' : '' }}>允许</option>
        <option value="false" {{ $if_allow_comment == 'false'?' selected' : '' }}>禁止</option>
    </select>
</div>

<div class="form-group date">
    <div class="row">
        <div class="col-sm-12">
	        <label for="image" class="control-label">发布时间</label>
            <input type="hidden" name="published_at" value="2029-01-01 00:00:00">
            <input type="text" name="published_at" class="form-control" id='published_at' value="{{ isset($page) ? $page->published_at : old('published_at') }}" autofocus>
        </div>
    </div>
</div>

<div class="form-group">
    <label>
        @php $is_draft = isset($page) ? $page->getConfig('is_draft', 'false') : 'false'; @endphp
        <input type="hidden" name="is_draft" value="false">
        <input type="checkbox" name="is_draft" id="is_draft" value="{{ $is_draft }}" {{ $is_draft === 'true'? 'checked' : '' }}>草稿
    </label>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success form-control">{{ $submitBtnTxt }}</button>
</div>

@section('scripts')
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="{{ asset('vendor/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script>

    new SimpleMDE({
        element: document.getElementById("editor"),
        placeholder: 'Please input the page content.',
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

        $('#is_draft').click(function() {
            var $publishedAt = $('#published_at').closest('.form-group');
            if ($(this).prop('checked')) {
                $publishedAt.hide().find('#published_at').attr('disabled', 'disabled');
            } else {
                $publishedAt.show().find('#published_at').removeAttr('disabled');
            }
        });
    });

</script>
@endsection