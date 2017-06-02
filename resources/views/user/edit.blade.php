@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">修改用户 <a class="btn btn-success btn-sm pull-right ion-android-people" href="{{ route('user.index')}}"> 用户列表</a></div>

                <div class="panel-body">
                    <form role="form" action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                        {{ method_field('patch') }}
                        @include('user.form', ['submitBtnTxt'=>'更新'])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {!! Toastr::message() !!}
@endsection