@extends('admin.master')

@section('page_title', $dataType->display_name_plural)

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-news"></i> {{ $dataType->display_name_plural }}
        @if (Admin::can('add_'.$dataType->name))
            <a href="{{ route('admin.'.$dataType->slug.'.create') }}" class="btn btn-success">
                <i class="voyager-plus"></i> @lang('Add New')
            </a>
        @endif
    </h1>
    @include('admin.multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('admin.alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                    <th>{{ $row->display_name }}</th>
                                    @endforeach
                                    <th class="actions">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataTypeContent as $data)
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                    <td>
                                        @if($row->type == 'image')
                                            <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false){{ Admin::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                        @else
                                            @if(is_field_translatable($data, $row))
                                                @include('admin.multilingual.input-hidden', [
                                                    '_field_name'  => $row->field,
                                                    '_field_trans' => get_field_translations($data, $row->field)
                                                ])
                                            @endif
                                            <span>{{ $data->{$row->field} }}</span>
                                        @endif
                                    </td>
                                    @endforeach
                                    <td class="no-sort no-click">
                                        @if (Admin::can('delete_'.$dataType->name))
                                            <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}">
                                                <i class="voyager-trash"></i> @lang('Delete')
                                            </div>
                                        @endif
                                        @if (Admin::can('edit_'.$dataType->name))
                                            <a href="{{ route('admin.'.$dataType->slug.'.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
                                                <i class="voyager-edit"></i> @lang('Edit')
                                            </a>
                                        @endif
                                        @if (Admin::can('read_'.$dataType->name))
                                            <a href="{{ route('admin.'.$dataType->slug.'.show', $data->id) }}" class="btn-sm btn-warning pull-right">
                                                <i class="voyager-eye"></i> @lang('View')
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (isset($dataType->server_side) && $dataType->server_side)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">显示 第{{ $dataTypeContent->firstItem() }} 到 第{{ $dataTypeContent->lastItem() }}条， 共 {{ $dataTypeContent->total() }} 条记录</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->links() }}
                            </div>
                        @endif
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
                        <i class="voyager-trash"></i> @lang('Are you sure you want to delete this')?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.'.$dataType->slug.'.destroy', ['id' => '__id']) }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="确定">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">@lang('Cancel')</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    {{-- DataTables --}}
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                $('#dataTable').DataTable({
                "order": [],
                language: {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                }
            });
            @endif
            @if ($isModelTranslatable)
                $('.side-body').multilingual();
            @endif
        });

        $('td').on('click', '.delete', function(e) {
            $('#delete_form')[0].action = $('#delete_form')[0].action.replace('__id', $(e.target).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
    @if($isModelTranslatable)
        <script src="{{ admin_asset('js/multilingual.js') }}"></script>
    @endif
@stop
