@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">分类管理 <a class="btn btn-success btn-sm pull-right" href="{{ route('category.create')}}">创建分类</a></div>

                    <div class="panel-body">
                        <table class="table table-hover table-top">
                            <tr>
                                <th>#</th>
                                <th>分类名称</th>
                                <th>创建时间</th>
                                <th class="text-right">操作</th>
                            </tr>

                            @foreach($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->html}} {{ $category->name }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('category.edit', ['id'=>$category->id]) }}"
                                           class="btn btn-primary btn-sm">
                                            修改
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0)" data-url="{{ route('category.destroy', ['id' => $category->id]) }}" data-dialog-msg="确定删除此分类?" data-dialog-title=" " data-enable-ajax="1"  class="btn btn-danger btn-sm swal-dialog-target">
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
