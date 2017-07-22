@extends('admin.master')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
    </h1>
@stop

@section('content')
    @include('admin.menus.partial.notice')

    <div class="page-content container-fluid">
        @include('admin.alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form class="navbar-form navbar-right" style="margin-top:-10px"
                              action="{{ route('admin.position-applications.index') }}" method="GET">
                            <div class="form-group">
                                <input style="width:120px" type="text" class="form-control" name="username"
                                       placeholder="姓名"
                                       value="{{ app('request')->input('username') }}">
                                <input style="width:150px" type="text" class="form-control" name="phone"
                                       placeholder="手机号"
                                       value="{{ app('request')->input('phone') }}">
                                <input style="width:120px" type="text" class="form-control" name="major"
                                       placeholder="专业"
                                       value="{{ app('request')->input('major') }}">
                                <input style="width:120px" type="text" class="form-control" name="city"
                                       placeholder="笔/面试城市"
                                       value="{{ app('request')->input('city') }}">
                                <select name="sex" id="sex" class="form-control">
                                    <option value="">选择性别</option>
                                    @foreach(\App\Models\PositionApplication::OPTIONS_SEX as $key => $val)
                                        <option @if(app('request')->input('sex') == $key) selected
                                                @endif value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                                <select name="education" id="education" class="form-control">
                                    <option value="">选择学历</option>
                                    @foreach(\App\Models\PositionApplication::OPTIONS_EDUCATION as $key => $val)
                                        <option @if(app('request')->input('education') == $key) selected
                                                @endif value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                                <select name="position_id" id="position_id" class="form-control">
                                    <option value="">选择职位</option>
                                    @foreach($positions as $val)
                                        <option @if(app('request')->input('position_id') == $val->id) selected
                                                @endif value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                                <select name="status" id="status" class="form-control">
                                    <option value="">选择状态</option>
                                    @foreach(\App\Models\PositionApplication::OPTIONS_STATUS as $key => $val)
                                        <option @if(app('request')->input('status') == $key) selected
                                                @endif value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">搜索</button>
                            <button type="button"
                                    onclick="location.href='{{ route("admin.position-applications.index") }}'"
                                    class="btn btn-default btn-sm">撤销
                            </button>
                        </form>
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                @foreach($dataType->browseRows as $rows)
                                    <th>{{ $rows->display_name }}</th>
                                @endforeach
                                <th class="actions">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applications as $application)
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                        <td>
                                            @if($row->type == 'image')
                                                <img src="@if( strpos($application->{$row->field}, 'http://') === false && strpos($application->{$row->field}, 'https://') === false){{ Admin::image( $application->{$row->field} ) }}@else{{ $application->{$row->field} }}@endif"
                                                     style="width:100px">
                                            @elseif($application->{$row->field} && in_array($row->field, ['position_id', 'position_id_updated']))
                                                {{ $application->position->name }}
                                            @elseif($row->type == 'file' && !empty($application->{$row->field}) )
                                                <a target="_blank"
                                                   href="/storage/{{ $application->{$row->field} }}">@lang('Download')</a>
                                            @else
                                                {{ __($application->{$row->field}) }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="no-sort no-click" id="bread-actions">
                                        @if (Admin::can('edit_'.$dataType->name) && !in_array($application->status, ['OK', 'Pass']))
                                            <a href="javascript:void(0)"
                                               class="btn btn-sm btn-success pull-right forward"
                                               style="cursor:pointer;margin-left:5px"
                                               data-id="{{ $application->id }}">
                                                <i class="voyager-paper-plane"></i> @lang('Forward Resume')
                                            </a>
                                        @endif
                                        @if (Admin::can('edit_'.$dataType->name))
                                            <a href="{{ route('admin.'.$dataType->slug.'.edit', $application->id) }}"
                                               title="@lang('View')" style="cursor:pointer;margin-left:5px" class="btn btn-sm btn-warning pull-right">
                                                <i class="voyager-edit"></i> <span
                                                        class="hidden-xs hidden-sm">@lang('Edit')</span>
                                            </a>
                                        @endif
                                        @if (Admin::can('read_'.$dataType->name))
                                            <a href="{{ route('admin.'.$dataType->slug.'.show', $application->id) }}"
                                               title="@lang('View')" class="btn btn-sm btn-warning pull-right">
                                                <i class="voyager-eye"></i> <span
                                                        class="hidden-xs hidden-sm">@lang('View')</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="pull-left">
                            <div role="status" class="show-res" aria-live="polite">
                                显示 第{{ $applications->firstItem() }} 到 第{{ $applications->lastItem() }}，
                                共 {{ $applications->total() }} 条记录
                            </div>
                        </div>
                        <div class="pull-right">
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> Are you sure you want to delete
                        this {{ $dataType->display_name_singular }}?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Delete This {{ $dataType->display_name_singular }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.position_applications.partials.forward_applications')
    
@stop

@section('javascript')
    <!-- DataTables -->
    <script>

        

        $('td').on('click', '.delete', function (e) {
            var id = $(e.target).data('id');

            $('#delete_form')[0].action += '/' + id;

            $('#delete_modal').modal('show');
        });

        

    </script>
@stop
