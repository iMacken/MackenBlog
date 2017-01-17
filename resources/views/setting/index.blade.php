@extends('backend.app')

@section('content')
    <div class="panel panel-default">
        {!! Notification::showAll() !!}
        <div class="panel-heading">基本设置</div>

        <div class="panel-body">
            {!! Form::open(['route' => 'backend.setting.save', 'method' => 'POST']) !!}
                <table class="table table-hover table-top">
                    <tr>
                        <th>#</th>
                        <th>名</th>
                        <th>值</th>
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
                    </tr>
                    @endforeach
                </table>
                
                {!! Form::submit('保存', ['class' => 'btn btn-success col-md-12']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
