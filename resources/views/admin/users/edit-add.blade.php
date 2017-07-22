@extends('admin.master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)){{ 'Edit' }}@else @lang('New') @endif {{ $dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title">@if(isset($dataTypeContent->id)) @lang('Edit') @else @lang('Add New') @endif {{ $dataType->display_name_singular }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-edit-add" role="form"
                          action="@if(isset($dataTypeContent->id)){{ route('admin.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('admin.'.$dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="@lang('Name')" id="name"
                                    value="@if(isset($dataTypeContent->name)){{ old('name', $dataTypeContent->name) }}@else{{old('name')}}@endif">
                            </div>

                            <div class="form-group">
                                <label for="name">@lang('Email')</label>
                                <input type="text" class="form-control" name="email"
                                       placeholder="@lang('Email')" id="email"
                                       value="@if(isset($dataTypeContent->email)){{ old('email', $dataTypeContent->email) }}@else{{old('email')}}@endif">
                            </div>

                            <div class="form-group">
                                <label for="password">@lang('Password')</label>
                                <input type="password" class="form-control" name="password"
                                       placeholder="@lang('Password')" id="password"
                                       value="{{$dataTypeContent->password}}">
                            </div>

                            <div class="form-group">
                                <label for="password">@lang('Avatar')</label>
                                @if(isset($dataTypeContent->avatar))
                                    <img src="{{ Admin::image( $dataTypeContent->avatar ) }}"
                                         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                @endif
                                <input type="file" name="avatar">
                            </div>

                            <div class="form-group">
                                <label for="role">@lang('Role')</label>
                                <select name="role_id" id="role" class="form-control">
                                    <?php $roles = App\Models\Role::all(); ?>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if(isset($dataTypeContent) && $dataTypeContent->role_id == $role->id) selected @endif>{{$role->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="department">@lang('Department')</label>
                                <select name="department_id" id="department" class="form-control">
                                    <?php $departments = App\Models\Department::all(); ?>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" @if(isset($dataTypeContent) && $dataTypeContent->department_id == $department->id) selected @endif>{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>



                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('admin.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
    <script src="{{ admin_asset('lib/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ admin_asset('js/admin_tinymce.js') }}"></script>
@stop
