@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">用户管理 <a class="btn btn-success btn-sm pull-right ion-person" href="{{ route('user.create')}}"> 创建用户</a></div>

                    <div class="panel-body">

                        <table class="table table-hover table-top">
                            <tr>
                                <th>#</th>
                                <th>姓名</th>
                                <th>邮箱</th>
                                <th>创建时间</th>
                                <th class="text-right">操作</th>
                            </tr>

                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('user.edit', ['id'=>$user->id]) }}"
                                           class="btn btn-primary btn-sm">
                                            <span class="ion-edit" aria-hidden="true"></span>
                                            修改
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0)" data-url="{{ route('user.destroy', ['id'=>$user->id]) }}" data-dialog-msg="确定删除此用户么?" data-dialog-title=" " class="btn btn-danger btn-sm op-delete ion-android-delete  swal-dialog-target">删除</a>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                        {!! $users->links() !!}
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
