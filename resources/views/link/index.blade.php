@extends('app')

@section('content')

    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">友链管理 <a class="btn btn-success btn-sm pull-right"
                                                       href="{{ route('link.create')}}">创建友链</a></div>

                    <div class="panel-body">
                        <table class="table table-hover table-top">
                            <tr>
                                <th>#</th>
                                <th>名称</th>
                                <th>地址</th>
                                <th>排序</th>
                                <th class="text-right">操作</th>
                            </tr>

                            @foreach($links as $link)
                                <tr>
                                    <th scope="row">{{ $link->id }}</th>
                                    <td>{{ $link->name }}</td>
                                    <td>{{ $link->url }}</td>
                                    <td>{{ $link->sort }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('link.edit', ['id'=>$link->id]) }}"
                                           class="btn btn-primary btn-sm">
                                            修改
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0)"
                                           data-url="{{ route('link.destroy', ['id' => $link->id]) }}"
                                           data-dialog-msg="确定删除此友链?" data-dialog-title=" " data-enable-ajax="1"
                                           class="btn btn-danger btn-sm swal-dialog-target">
                                            删除
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
