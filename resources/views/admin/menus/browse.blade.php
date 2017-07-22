@extends('admin.master')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list-add"></i> {{ $dataType->display_name_plural }}
        {{--@if (Admin::can('add_'.$dataType->name))--}}
            {{--<a href="{{ route('admin.'.$dataType->slug.'.create') }}" class="btn btn-success">--}}
                {{--<i class="voyager-plus"></i> @lang('Add New')--}}
            {{--</a>--}}
        {{--@endif--}}
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
                            @foreach($dataTypeContent as $data)
                                @php if ($data->name === 'admin') continue; @endphp
                                    <tr>
                                        @foreach($dataType->browseRows as $row)
                                            <td>
                                                @if($row->type == 'image')
                                                    <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false){{ Admin::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif"
                                                         style="width:100px">
                                                @else
                                                    {{ $data->{$row->field} }}
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="no-sort no-click">
                                            {{--@if (Admin::can('delete_'.$dataType->name))--}}
                                                {{--<div class="btn-sm btn-danger pull-right delete"--}}
                                                     {{--data-id="{{ $data->id }}">--}}
                                                    {{--<i class="voyager-trash"></i> @lang('Delete')--}}
                                                {{--</div>--}}
                                            {{--@endif--}}
                                            {{--@if (Admin::can('edit_'.$dataType->name))--}}
                                                {{--<a href="{{ route('admin.'.$dataType->slug.'.edit', $data->id) }}"--}}
                                                   {{--class="btn-sm btn-primary pull-right edit">--}}
                                                    {{--<i class="voyager-edit"></i> @lang('Edit')--}}
                                                {{--</a>--}}
                                            {{--@endif--}}
                                            @if (Admin::can('edit_'.$dataType->name))
                                                <a href="{{ route('admin.'.$dataType->slug.'.builder', $data->id) }}"
                                                   class="btn-sm btn-success pull-right">
                                                    <i class="voyager-edit"></i> @lang('Edit')
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="pull-left">
                            <div role="status" class="show-res" aria-live="polite">
                                显示 第{{ $dataTypeContent->firstItem() }} 到 第{{ $dataTypeContent->lastItem() }}，
                                共 {{ $dataTypeContent->total() }} 条记录
                            </div>
                        </div>
                        <div class="pull-right">
                            {{ $dataTypeContent->links() }}
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
@stop

@section('javascript')
    <!-- DataTables -->
    <script>

        $('td').on('click', '.delete', function (e) {
            id = $(e.target).data('id');

            $('#delete_form')[0].action += '/' + id;

            $('#delete_modal').modal('show');
        });
    </script>
@stop
