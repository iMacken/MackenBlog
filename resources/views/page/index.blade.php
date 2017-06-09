@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">单页管理 <a class="btn btn-success btn-sm pull-right" href="{{ route('page.create')}}">创建单页</a></div>

                    <div class="panel-body">
                        <table class="table table-hover table-top">
                            <tr>
                                <th>#</th>
                                <th>单页名称</th>
                                <th>创建时间</th>
                                <th class="text-right">操作</th>
                            </tr>

                            @foreach($pages as $page)
                                <tr>
                                    <th scope="row">{{ $page->id }}</th>
                                    <td>{{ $page->title }}</td>
                                    <td>{{ $page->created_at }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('page.edit', ['id'=>$page->id]) }}"
                                           class="btn btn-primary btn-sm">
                                            修改
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0)" data-url="{{ route('page.destroy', ['id' => $page->id]) }}" data-dialog-msg="确定删除此单页?" data-dialog-title=" " data-enable-ajax="1"  class="btn btn-danger btn-sm swal-dialog-target">
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
