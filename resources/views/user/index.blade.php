@extends('backend.app')

@section('content')
    <div class="col-md-12">
        <div class="panel panel-default">
            {!! Notification::showAll() !!}
            <div class="panel-heading">用户管理</div>

            <div class="panel-body">
                <a class="btn btn-success" href="{{ URL::route('backend.user.create')}}">创建用户</a>

                <table class="table table-hover table-top">
                    <tr>
                        <th>#</th>
                        <th>姓名</th>
                        <th>邮箱</th>
                        <th>创建时间</th>
                        <th class="text-right">操作</th>
                    </tr>

                    @foreach($users as $k=> $v)
                    <tr>
                        <th scope="row">{{ $v->id }}</th>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->email }}</td>
                        <td>{{ $v->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-right">
                            <a href="{{ route('backend.user.edit', ['id'=>$v->id]) }}" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                修改
                            </a>
                            &nbsp;
                            <a href="javascript:void(0)" data-target="{{ url("backend/user/{$v->id}") }}" class="btn btn-danger btn-sm op-delete">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            删除
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </table>

            </div>
            {!! $users->render() !!}
        </div>
    </div>

    @include('backend.partials.delete')
@endsection
