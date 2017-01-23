@extends('app')

@section('content')
    <div class="col-md-12">
    {!! Notification::showAll() !!}
        <div class="panel panel-default">
            
            <div class="panel-heading">标签管理</div>

            <div class="panel-body">
                <a class="btn btn-success" href="{{ URL::route('tag.create')}}">创建标签</a>

                <table class="table table-hover table-top">
                    <tr>
                        <th>#</th>
                        <th>标签名</th>
                        <th>引用次数</th>
                        <th class="text-right">操作</th>
                    </tr>

                    @foreach($tags as $k=> $v)
                    <tr>
                        <th scope="row">{{ $v->id }}</th>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->number }}</td>
                        <td class="text-right">
                            <a href="{{ route('tag.edit', ['id'=>$v->id]) }}" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                修改
                            </a>
                            &nbsp;
                            <a href="javascript:void(0)" data-target="{{ url("backend/tag/{$v->id}") }}" class="btn btn-danger btn-sm op-delete">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            删除
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
            {!! $tags->render() !!}
        </div>
    </div>

    @include('partials.delete')
@endsection
