@extends('admin.master')

@if(isset($dataTypeContent->id))
    @section('page_title', __('Edit') . ' ' .$dataType->display_name_singular)
@else
    @section('page_title', __('Add') . ' ' .$dataType->display_name_singular)
@endif

@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>

    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id))@lang('Edit')@else @lang('New')@endif {{ $dataType->display_name_singular }}
    </h1>
    @include('admin.multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" action="@if(isset($dataTypeContent->id)){{ route('admin.posts.update', $dataTypeContent->id) }}@else{{ route('admin.posts.store') }}@endif" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> @lang('Post') @lang('Title')
                                {{--<span class="panel-desc"> The title for your post</span>--}}
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.multilingual.input-hidden', [
                                '_field_name'  => 'title',
                                '_field_trans' => get_field_translations($dataTypeContent, 'title')
                            ])
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="@if(isset($dataTypeContent->title)){{ $dataTypeContent->title }}@endif">
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i> @lang('Post') @lang('Content')</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        @include('admin.multilingual.input-hidden', [
                            '_field_name'  => 'body',
                            '_field_trans' => get_field_translations($dataTypeContent, 'body', 'rich_text_box', true)
                        ])
                        <textarea class="form-control richTextBox" id="richtextbody" name="body" style="border:0px;">@if(isset($dataTypeContent->body)){{ $dataTypeContent->body }}@endif</textarea>
                    </div><!-- .panel -->

                    <!-- ### EXCERPT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">@lang('Excerpt') <small>@lang('Small description of this post')</small></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('admin.multilingual.input-hidden', [
                                '_field_name'  => 'excerpt',
                                '_field_trans' => get_field_translations($dataTypeContent, 'excerpt')
                            ])
                            <textarea class="form-control" name="excerpt">@if (isset($dataTypeContent->excerpt)){{ $dataTypeContent->excerpt }}@endif</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> @lang('Post') @lang('Detail')</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">URL @lang('Slug')</label>
                                @include('admin.multilingual.input-hidden', [
                                    '_field_name'  => 'slug',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'slug')
                                ])
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="@lang('Slug')"
                                    {{!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}}
                                    value="@if(isset($dataTypeContent->slug)){{ $dataTypeContent->slug }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('Post') @lang('Status')</label>
                                <select class="form-control" name="status">
                                    <option value="Published" @if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PUBLISHED'){{ 'selected="selected"' }}@endif>@lang('Published')</option>
                                    <option value="Draft" @if(isset($dataTypeContent->status) && $dataTypeContent->status == 'DRAFT'){{ 'selected="selected"' }}@endif>@lang('Draft')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('Post') @lang('Category')</label>
                                <select class="form-control" name="category_id">
                                    @foreach(App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" @if(isset($dataTypeContent->category_id) && $dataTypeContent->category_id == $category->id){{ 'selected="selected"' }}@endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('Featured')</label>
                                <input type="checkbox" name="featured" @if(isset($dataTypeContent->featured) && $dataTypeContent->featured){{ 'checked="checked"' }}@endif>&nbsp;
                            </div>

                            <div class="form-group">
                                <label for="if_allow_comment" class="control-label">@lang('Comment Toggle')</label>
                                <select id="if_allow_comment" name="if_allow_comment" class="form-control">
                                    @php $if_allow_comment = isset($dataTypeContent) ? $dataTypeContent->getConfig('if_allow_comment', 'true') : 'true'; @endphp
                                    <option value="true" {{ $if_allow_comment == 'true'?' selected' : '' }}>@lang('Enable')</option>
                                    <option value="false" {{ $if_allow_comment == 'false'?' selected' : '' }}>@lang('Disable')</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> @lang('Post') @lang('Image')</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(isset($dataTypeContent->image))
                                <img src="{{ Admin::image( $dataTypeContent->image ) }}" style="width:100%" />
                            @endif
                            <input type="file" name="image">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-left">
                @if(isset($dataTypeContent->id))@lang('Update') @lang('Post')@else <i class="icon wb-plus-circle"></i> Create New Post @endif
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('admin.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

        @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
        @endif
        });
    </script>
    @if($isModelTranslatable)
        <script src="{{ admin_asset('js/multilingual.js') }}"></script>
    @endif
    <script src="{{ admin_asset('lib/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ admin_asset('js/admin_tinymce.js') }}"></script>
    <script src="{{ admin_asset('js/slugify.js') }}"></script>
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#tag_list').select2({
            placeholder: '选择一个标签',
            tags: true
        });
    </script>
@stop
