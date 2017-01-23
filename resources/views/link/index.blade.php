@extends('app')

@section('content')

    <div class="panel panel-default">
        {!! Notification::showAll() !!}
        <div class="panel-heading">友链管理</div>

        <div class="panel-body">
            <a class="btn btn-success" href="{{ route('link.create')}}">添加友链</a>

            <table class="table table-hover table-top">
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>地址</th>
                    <th>排序</th>
                    <th>创建时间</th>
                    <th class="text-right">操作</th>
                </tr>

                @foreach($list as $k=> $v)
                <tr>
                    <th scope="row">{{ $v->id }}</th>
                    <td>{{ $v->name }}</td>
                    <td>{{ $v->url }}</td>
                    <td>{{ $v->sequence }}</td>
                    <td>{{ $v->created_at }}</td>
                    <td class="text-right">
                        <a href="{{ route('link.edit', ['id'=>$v->id]) }}" class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            修改
                        </a>
                        &nbsp;
                        <a href="javascript:void(0)" data-target="{{ url("backend/link/{$v->id}") }}" class="btn btn-danger btn-sm op-delete">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        删除
                        </a>
                    </td>

                </tr>
                @endforeach
            </table>

        </div>
    </div>
    
    @include('partials.delete')
@endsection
