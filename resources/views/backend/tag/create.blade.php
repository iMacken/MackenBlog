@extends('backend.app')

@section('content')
<div class="col-md-10">
    <div class="panel panel-default">
        <div class="panel-heading">创建标签</div>

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
            {!! Form::open(['route' => 'backend.tag.store', 'method' => 'POST']) !!}

            @include('backend.tag.form', ['submitBtnTxt'=>'完成'])
            
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
