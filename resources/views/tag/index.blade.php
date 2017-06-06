@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading">标签管理 <a class="btn btn-success btn-sm pull-right"
                                                       href="{{ route('tag.create')}}">创建标签</a></div>

                    <div class="panel-body">
                        <table class="table table-hover table-top">
                            <tr>
                                <th>#</th>
                                <th>标签名</th>
                                <th>引用次数</th>
                                <th class="text-right">操作</th>
                            </tr>

                            @foreach($tags as $tag)
                                <tr>
                                    <th scope="row">{{ $tag->id }}</th>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->number }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('tag.edit', ['id'=>$tag->id]) }}"
                                           class="btn btn-primary btn-sm">
                                            修改
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0)"
                                           data-url="{{ route('tag.destroy', ['id' => $tag->id]) }}"
                                           data-dialog-msg="确定删除此标签?" data-dialog-title=" " data-enable-ajax="1"
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

@section('scripts')
    {!! Toastr::message() !!}
@endsection
