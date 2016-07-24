@extends('backend.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">修改分类</div>

        @if ($errors->has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong>
            {{ $errors->first('error', ':message') }}
            <br />
        </div>
        @endif

        <div class="panel-body">
            {!! Form::model($category, ['route' => ['backend.category.update', $category->id], 'method' => 'PATCH']) !!}
            
            @include('backend.category.form', ['submitBtnTxt'=>'更新'])
            
            {!! Form::close() !!}
        </div>
    </div>

@endsection