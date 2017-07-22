@extends('admin.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ admin_asset('css/nestable.css') }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-group"></i> @lang('Department')
        <div class="btn btn-success add_item"><i class="voyager-plus"></i> @lang('New') @lang('Department')</div>
    </h1>
    @include('admin.multilingual.language-selector')
@stop

@section('content')
    @include('admin.departments.partial.notice')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <p class="panel-title"
                           style="color:#777">@lang('Drag and drop the items below to re-arrange them')</p>
                    </div>

                    <div class="panel-body" style="padding:30px;">
                        <div class="dd">
                            @include('admin.departments.partial.list_default')
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> @lang('Are you sure you want to delete this')?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.departments.destroy', ['id' => '__id']) }}"
                          id="delete_form"
                          method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="@lang('Yes, Delete This')">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">@lang('Cancel')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal modal-info fade" tabindex="-1" id="department_item_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 id="m_hd_add" class="modal-title hidden"><i
                                class="voyager-plus"></i> @lang('Create') @lang('Department')</h4>
                    <h4 id="m_hd_edit" class="modal-title hidden"><i
                                class="voyager-edit"></i> @lang('Edit') @lang('Department')</h4>
                </div>
                <form action="" id="m_form" method="POST"
                      data-action-add="{{ route('admin.departments.store') }}"
                      data-action-update="{{ route('admin.departments.update', ['id' => '__id']) }}">

                    <input id="m_form_method" type="hidden" name="_method" value="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        @include('admin.multilingual.language-selector')
                        <label for="name">@lang('Name')</label>
                        @include('admin.multilingual.input-hidden', ['_field_name' => 'name', '_field_trans' => ''])
                        <input type="text" class="form-control" id="m_name" name="name" placeholder="@lang('Name')"><br>
                        <input type="hidden" name="id" id="m_id" value="">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right delete-confirm__"
                               value="@lang('Update')">
                        <button type="button" class="btn btn-default pull-right"
                                data-dismiss="modal">@lang('Cancel')</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




@stop

@section('javascript')

    <script type="text/javascript" src="{{ admin_asset('js/jquery.nestable.js') }}"></script>
    @if($isModelTranslatable)
        <script type="text/javascript" src="{{ admin_asset('js/multilingual.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if ($isModelTranslatable)
            /**
             * Multilingual setup for main page
             */
            $('.side-body').multilingual({
                "transInputs": '.dd-list input[data-i18n=true]'
            });

            /**
             * Multilingual for Add/Edit Department
             */
            $('#department_item_modal').multilingual({
                "form": 'form',
                "transInputs": '#department_item_modal input[data-i18n=true]',
                "langSelectors": '.language-selector input',
                "editing": true
            });
            @endif


            $('.dd').nestable({/* config options */});


            /**
             * Set Variables
             */
            var $m_modal = $('#department_item_modal'),
                $m_hd_add = $('#m_hd_add').hide().removeClass('hidden'),
                $m_hd_edit = $('#m_hd_edit').hide().removeClass('hidden'),
                $m_form = $('#m_form'),
                $m_form_method = $('#m_form_method'),
                $m_name = $('#m_name'),
                $m_name_i18n = $('#name_i18n'),
                $m_id = $('#m_id');
            /**
             * Add Department
             */
            $('.add_item').click(function () {
                $m_modal.modal('show', {data: null});
            });

            /**
             * Edit Department
             */
            $('.item_actions').on('click', '.edit', function (e) {
                id = $(e.currentTarget).data('id');
                $m_form.data('action-update', $m_form.data('action-update').replace("__id", id));
                $m_modal.modal('show', {data: $(e.currentTarget)});
            });

            /**
             * Department Modal is Open
             */
            $m_modal.on('show.bs.modal', function (e, data) {
                var _adding = e.relatedTarget.data ? false : true,
                    translatable = $m_modal.data('multilingual'),
                    $_str_i18n = '';

                if (_adding) {
                    $m_form.attr('action', $m_form.data('action-add'));
                    $m_form_method.val('POST');
                    $m_hd_add.show();
                    $m_hd_edit.hide();

                } else {
                    $m_form.attr('action', $m_form.data('action-update'));
                    $m_form_method.val('PUT');
                    $m_hd_add.hide();
                    $m_hd_edit.show();

                    var _src = e.relatedTarget.data, // the source
                        id = _src.data('id');

                    $m_name.val(_src.data('name'));
                    $m_id.val(id);

                    if (translatable) {
                        $_str_i18n = $("#name" + id + "_i18n").val();
                    }
                }

                if (translatable) {
                    $m_name_i18n.val($_str_i18n);
                    translatable.refresh();
                }
            });



            /**
             * Delete department item
             */
            $('.item_actions').on('click', '.delete', function (e) {
                id = $(e.currentTarget).data('id');
                $('#delete_form')[0].action = $('#delete_form')[0].action.replace("__id", id);
                $('#delete_modal').modal('show');
            });


            /**
             * Reorder items
             */
            $('.dd').on('change', function (e) {
                id = $(e.currentTarget).data('id');
                $.post('{{ route('admin.departments.order') }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    toastr.success("@lang('Successfully updated order')");
                });
            });
        });
    </script>
@stop
