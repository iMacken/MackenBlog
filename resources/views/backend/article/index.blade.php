@extends('backend.app')

@section('content')

    {!! Notification::showAll() !!}
        <div class="panel panel-default">
            
            <div class="panel-heading">文章管理</div>

            <div class="panel-body">
                <a class="btn btn-success" href="{{ URL::route('article.create')}}">创建文章</a>

                <table class="table table-hover table-top">
                    <tr>
                        <th>#</th>
                        <th>标题</th>
                        <th>所属分类</th>
                        <th>作者</th>
                        <th>浏览次数</th>
                        <th>创建时间</th>
                        <th class="text-right">操作</th>
                    </tr>

                    @foreach($articles as $k => $v)
                    <tr>
                        <th>{{ $v->id }}</th>
                        <td>{{ $v->title }}</td>
                        <td>{!! $v->category ? $v->category->name : '单页' !!}</td>
                        <td>{{ $v->user->name }}</td>
                        <td>{{ $v->status['views'] }}</td>
                        <td>{{ $v->created_at }}</td>
                        <td class="text-right">
                            <a href="{{ route('article.edit', ['id'=>$v->id]) }}" class="btn btn-primary btn-sm">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                修改
                            </a>
                            &nbsp;
                            <a href="javascript:void(0)" data-target="{{ url("backend/article/{$v->id}") }}" class="btn btn-danger btn-sm op-delete">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                删除
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
            {!! $articles->render() !!}
        </div>

        @include('backend.partials.delete')

@endsection


