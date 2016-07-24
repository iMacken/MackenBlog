@extends('backend.app')

@section('content')
    <div class="panel panel-default">
        {!! Notification::showAll() !!}
        <div class="panel-heading">基本设置</div>

        <div class="panel-body">
            <a class="btn btn-success" href="{{ url('/backend/setting/create') }}">创建设置</a>
            {!! Form::open(['url' => 'backend/setting/store', 'method' => 'POST']) !!}
                <table class="table table-hover table-top">
                    <tr>
                        <th>#</th>
                        <th>名</th>
                        <th>值</th>
                        <th class="text-right">操作</th>
                    </tr>

                    @foreach($setting as $k=> $v)
                    <tr>
                        <th>{{ $v->id }}</th>
                        <td>
                            {{ trans('backend_config.'.$v->name) }}
                        </td>
                        <td>
                            {!! Form::text('setting['.$v->name.']', $v->value, ['class' => 'form-control']) !!}
                        </td>
                        <td class="text-right">
                            <a href="javascript:void(0)" data-target="{{ url('/backend/setting/delete',['id'=>$v->id]) }}" class="btn btn-danger btn-sm op-delete">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            删除
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                
                {!! Form::submit('保存', ['class' => 'btn btn-success col-md-12']) !!}

            {!! Form::close() !!}
        </div>
    </div>

    <script type="text/javascript">
        $(document).on('click', '.op-delete', function(event){
            event.preventDefault();
            var href = $(this).attr('data-target');
            swal({
                title: "",
                text: '确认删除?',
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                location.href = href;
            });
        })
    </script>
@endsection
