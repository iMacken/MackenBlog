@extends('admin.master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)) @lang('Edit') @else @lang('New') @endif {{ $dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('admin.alerts')
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

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach($dataType->addRows as $row)
                                <div class="form-group">
                                    <label for="name">{{ $row->display_name }}</label>

                                    {!! Admin::formField($row, $dataType, $dataTypeContent) !!}

                                </div>
                            @endforeach

                            <label for="permission">@lang('Permissions')</label><br>
                            <a href="#" class="permission-select-all">@lang('Select All')</a> / <a href="#"  class="permission-deselect-all">@lang('Deselect All')</a>
                            <ul class="permissions checkbox">
                                <?php
                                    $role_permissions = (isset($dataTypeContent)) ? $dataTypeContent->permissions->pluck('key')->toArray() : [];
                                ?>
                                @foreach(App\Models\Permission::all()->groupBy('table_name') as $table => $permission)
                                    <li>
                                        <input type="checkbox" id="{{$table}}" class="permission-group">
                                        <label for="{{$table}}"><strong> @lang(ucwords($table)) </strong></label>
                                        <ul>
                                            @foreach($permission as $perm)
                                                <li>
                                                    <input type="checkbox" id="permission-{{$perm->id}}" name="permissions[]" class="the-permission" value="{{$perm->id}}" @if(in_array($perm->key, $role_permissions)) checked @endif>
                                                    <label for="permission-{{$perm->id}}">@php $permArr = explode('_', $perm->key); echo __(ucwords($permArr[0])) . ' ' . (isset($permArr[2]) ? __(ucwords($permArr[1] . ' ' . $permArr[2])) : __(ucwords($permArr[1]))); @endphp</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- panel-body -->
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('admin.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        {{ csrf_field() }}
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
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

            $('.permission-group').on('change', function(){
                $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
            });

            $('.permission-select-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked(){
                $('.permission-group').each(function(){
                    var allChecked = true;
                    $(this).siblings('ul').find("input[type='checkbox']").each(function(){
                        if(!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function(){
                parentChecked();
            });
        });
    </script>
    <script src="{{ admin_asset('lib/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ admin_asset('js/admin_tinymce.js') }}"></script>
@stop
