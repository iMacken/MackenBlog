@extends('app')

@section('content')

    {!! Notification::showAll() !!}
        <div class="panel panel-default">
            <div class="panel-heading">分类管理</div>

            <div class="panel-body">
                <a class="btn btn-success" href="{{ URL::route('category.create')}}">创建分类</a>

                <table class="table table-hover table-top">
                    <tr>
                        <th>#</th>
                        <th>分类名称</th>
                        <th>创建时间</th>
                        <th class="text-right">操作</th>
                    </tr>

                    @foreach($category as $k=> $v)
                    <tr>
                        <th scope="row">{{ $v->id }}</th>
                        <td>{{ $v->html}} {{ $v->name }}</td>
                        <td>{{ $v->created_at }}</td>
                        <td class="text-right">
                            <a href="{{ route('category.edit', ['id'=>$v->id]) }}" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                修改
                            </a>
                            &nbsp;
                            <a href="javascript:void(0)" data-target="{{ url("backend/category/{$v->id}") }}" class="btn btn-danger btn-sm op-delete">
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
