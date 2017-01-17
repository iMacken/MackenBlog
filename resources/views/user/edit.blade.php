@extends('backend.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">修改用户</div>

        @if ($errors->has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong>
            {{ $errors->first('error', ':message') }}
            <br />
            请联系开发者！
        </div>
        @endif

        <div class="panel-body">
            {!! Form::model($user, ['route' => ['backend.user.update', $user->id], 'method' => 'PATCH','enctype'=>'multipart/form-data']) !!}
            
            @include('backend.user.form', ['submitBtnTxt'=>'更新'])

            {!! Form::close() !!}
        </div>
    </div>

@endsection