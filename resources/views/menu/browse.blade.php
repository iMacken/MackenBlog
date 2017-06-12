@extends('app')

@section('content')

    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th class="actions">菜单</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataTypeContent as $data)
                                <tr>
                                    <td>
                                        {{ $data->{$row->field} }}
                                    </td>
                                    <td class="no-sort no-click">
                                        <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}">
                                            <i class="voyager-trash"></i> Delete
                                        </div>
                                        <a href="{{ route('admin.'.$dataType->slug.'.edit', $data->id) }}"
                                           class="btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.'.$dataType->slug.'.builder', $data->id) }}"
                                           class="btn-sm btn-success pull-right">
                                            <i class="voyager-list"></i> Builder
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
    </section>
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({"order": []});
        });

        $('td').on('click', '.delete', function (e) {
            id = $(e.target).data('id');

            $('#delete_form')[0].action += '/' + id;

            $('#delete_modal').modal('show');
        });
    </script>
@stop
