@extends('master')

@section('page_title', '')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-news"></i>
        <a href="" class="btn btn-success">
            <i class="voyager-plus"></i> @lang('action.add_new')
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="actions">@lang('action.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>
                                        <span>{{ $post->{$row->field} }}</span>
                                    </td>
                                    <td class="no-sort no-click">
                                        <div class="btn-sm btn-danger pull-right delete" data-id="{{ $post->id }}">
                                            <i class="voyager-trash"></i> @lang('action.delete')
                                        </div>
                                        <a href="{{ route('admin.post.edit', $post->id) }}" class="btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> @lang('action.edit')
                                        </a>
                                        <a href="{{ route('admin.post.show', $post->id) }}" class="btn-sm btn-warning pull-right">
                                            <i class="voyager-eye"></i> @lang('action.view')
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">显示 第{{ $posts->firstItem() }} 到 第{{ $posts->lastItem() }}条， 共 {{ $posts->total() }} 条记录</div>
                            </div>
                            <div class="pull-right">
                                {{ $posts->links() }}
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
                        <i class="voyager-trash"></i> @lang('Are you sure you want to delete this')?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.'.$postType->slug.'.destroy', ['id' => '__id']) }}" id="delete_form" method="POST">
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
    <script>
        $('td').on('click', '.delete', function(e) {
            $('#delete_form')[0].action = $('#delete_form')[0].action.replace('__id', $(e.target).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
@stop
