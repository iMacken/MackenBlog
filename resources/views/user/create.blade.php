@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">创建用户 <a class="btn btn-success btn-sm pull-right ion-android-people"
                                                   href="{{ route('user.index')}}"> 用户列表</a></div>
                <div class="panel-body">
                    <form role="form" action="{{ route('user.store') }}" method="POST">
                        @include('user.form', ['submitBtnTxt'=>'完成'])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
