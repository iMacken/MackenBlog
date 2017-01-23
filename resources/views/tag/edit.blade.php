@extends('app')

@section('content')
<div class="col-md-10">
    <div class="panel panel-default">
        <div class="panel-heading">修改标签</div>

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
            {!! Form::model($tag, ['route' => ['tag.update', $tag->id], 'method' => 'PATCH']) !!}
            
            @include('tag.form', ['submitBtnTxt'=>'更新'])

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
